<?php
/**
 * This file is part of the dingtalk.
 * User: Ilham Tahir <yantaq@bilig.biz>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Aplisin\DingTalk\Kernel\Providers;

use Pimple\ServiceProviderInterface;
use Aplisin\DingTalk\Kernel\Log\LogManager;
use Pimple\Container;

class LogServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['logger'] = $pimple['log'] = function($app) {
            $config = $this->formatLogConfig($app);

            if (!empty($config)) {
                $app['config']->merge($config);
            }

            return new LogManager($app);
        };
    }

    public function formatLogConfig($app)
    {
        if (empty($app['config']->get('log'))) {
            return [
                'log' => [
                    'default' => 'errorlog',
                    'channels' => [
                        'errorlog' => [
                            'driver' => 'errorlog',
                            'level' => 'debug',
                        ],
                    ],
                ],
            ];
        }

        // 4.0 version
        if (empty($app['config']->get('log.driver'))) {
            return [
                'log' => [
                    'default' => 'single',
                    'channels' => [
                        'single' => [
                            'driver' => 'single',
                            'path' => $app['config']->get('log.file') ?: \sys_get_temp_dir().'/logs/dingtalk.log',
                            'level' => $app['config']->get('log.level', 'debug'),
                        ],
                    ],
                ],
            ];
        }

        $name = $app['config']->get('log.driver');

        return [
            'log' => [
                'default' => $name,
                'channels' => [
                    $name => $app['config']->get('log'),
                ],
            ],
        ];
    }
}
