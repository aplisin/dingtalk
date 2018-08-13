<?php
/**
 * This file is part of the dingtalk.
 * User: Ilham Tahir <yantaq@bilig.biz>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Aplisin\DingTalk\Kernel\Log;

use Aplisin\DingTalk\Kernel\ServiceContainer;
use Psr\Log\LoggerInterface;
use Monolog\Logger as Monolog;

class LogManager implements LoggerInterface
{
    /**
     * @var ServiceContainer
     */
    protected $app;

    /**
     * @var array
     */
    protected $channels = [];

    protected $customCreators = [];

    protected $levels = [
        'debug' => Monolog::DEBUG,
        'info' => Monolog::INFO,
        'notice' => Monolog::NOTICE,
        'warning' => Monolog::WARNING,
        'error' => Monolog::ERROR,
        'critical' => Monolog::CRITICAL,
        'alert' => Monolog::ALERT,
        'emergency' => Monolog::EMERGENCY,
    ];

    /**
     * LogManager constructor.
     * @param ServiceContainer $app
     */
    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }

    /**
     * @param array $channels
     * @param null $channel
     * @return LoggerInterface
     */
    public function stack(array $channels, $channel = null)
    {
        return $this->createStackDriver(compact('channels', 'channel'));
    }

    public function channel($channel = null)
    {
        return $this->get($channel);
    }

    public function driver($driver = null)
    {
        return $this->get($driver ?? $this->getDefaultDriver());
    }

    /**
     * @param $name
     * @return LoggerInterface
     */
    protected function get($name)
    {
        try {
            return $this->channels[$name] ?? ($this->channels[$name] = $this->resolve($name));
        } catch (\Throwable $e) {
            $logger = $this->createEmergencyLogger();

            $logger->emergency('Unable to create configured logger. Using emergency logger.', [
                'exception' => $e,
            ]);

            return $logger;
        }
    }

    protected function resolve($name)
    {
        $config = $this->app['config']->get(\sprintf('log.channels.%s', $name));

        if (is_null($config)) {
            throw new \InvalidArgumentException(\sprintf('Log [%s] is not defined.', $name));
        }

        if (isset($this->customCreators[$config['driver']])) {
            return $this->callCustomCreator($config);
        }

        $driverMethod = 'create'.ucfirst($config['driver']).'Driver';

        if (method_exists($this, $driverMethod)) {
            return $this->{$driverMethod}($config);
        }

        throw new \InvalidArgumentException(\sprintf('Driver [%s] is not supported.', $config['driver']));
    }

    protected function createEmergencyLogger()
    {
        return new Monolog('AplisinDingTalk', $this->prepareHandlers([
            new StreamHandler(\sys_get_temp_dir().'/dingtalk/dingtalk.log', $this->level(['level' => 'debug']))
        ]));
    }

    protected function callCustomCreator(array $config)
    {
        return $this->customCreators[$config['driver']]($this->app, $config);
    }

    protected function createStackDriver(array $config)
    {
        $handlers = [];

        foreach ($config['channels'] ?? [] as $channel) {
            $handlers = \array_merge($handlers, $this->channel($channel)->getHandlers());
        }

        return new Monolog($this->parseChannel($config), $handlers);
    }

    protected function createSingleDriver(array $config)
    {
        return new Monolog($this->parseChannel($config), [
            $this->prepareHandler(
                new StreamHandler($config['path'], $this->level($config))
            ),
        ]);
    }

    protected function createDailyDriver(array $config)
    {
        return new Monolog($this->parseChannel($config), [
            $this->prepareHandler(new RotatingFileHandler(
                $config['path'], $config['days'] ?? 7, $this->level($config)
            )),
        ]);
    }

    protected function createSlackDriver(array $config)
    {
        return new Monolog($this->parseChannel($config), [
            $this->prepareHandler(new SlackWebhookHandler(
                $config['url'],
                $config['channel'] ?? null,
                $config['username'] ?? 'AplisinDingTalk',
                $config['attachment'] ?? true,
                $config['emoji'] ?? ':boom:',
                $config['short'] ?? false,
                $config['context'] ?? true,
                $this->level($config)
            )),
        ]);
    }
}
