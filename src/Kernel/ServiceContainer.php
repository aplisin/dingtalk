<?php
/**
 * This file is part of the dingtalk.
 * User: Ilham Tahir <yantaq@bilig.biz>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Aplisin\DingTalk\Kernel;

use Aplisin\DingTalk\Kernel\Providers\ConfigServiceProvider;
use Aplisin\DingTalk\Kernel\Providers\ExtensionServiceProvider;
use Aplisin\DingTalk\Kernel\Providers\HttpClientServiceProvider;
use Aplisin\DingTalk\Kernel\Providers\LogServiceProvider;
use Aplisin\DingTalk\Kernel\Providers\RequestServiceProvider;
use Pimple\Container;

class ServiceContainer extends Container
{
    protected $id;

    protected $providers = [];

    protected $userConfig = [];

    public function __construct(array $config = [], array $prepends = [], string $id = null)
    {
        $this->registerProviders($this->getProviders());
        parent::__construct($prepends);
        $this->userConfig = $config;
        $this->id = $id;
    }

    public function getProviders()
    {
        return array_merge([
            ConfigServiceProvider::class,
            LogServiceProvider::class,
            RequestServiceProvider::class,
            HttpClientServiceProvider::class,
            ExtensionServiceProvider::class
        ], $this->providers);
    }

    /**
     * Magic get access.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function __get($id)
    {
        return $this->offsetGet($id);
    }
    /**
     * Magic set access.
     *
     * @param string $id
     * @param mixed  $value
     */
    public function __set($id, $value)
    {
        $this->offsetSet($id, $value);
    }

    /**
     * @param array $providers
     */
    public function registerProviders(array $providers)
    {
        foreach ($providers as $provider) {
            parent::register(new $provider);
        }
    }
}
