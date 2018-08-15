<?php
/**
 * This file is part of the dingtalk.
 * User: Ilham Tahir <yantaq@bilig.biz>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Aplisin\DingTalk;

use Aplisin\DingTalk\Department\ServiceProvider;
use Aplisin\DingTalk\Kernel\ServiceContainer;

/**
 * Class Application
 * @property \Aplisin\DingTalk\Auth\AccessToken $access_token
 * @property \Aplisin\DingTalk\Department\Client $department
 */
class Application extends ServiceContainer
{
    protected $providers = [
        Auth\ServiceProvider::class,
        ServiceProvider::class
    ];

    protected $defaultConfig = [
        // http://docs.guzzlephp.org/en/stable/request-options.html
        'http' => [
            'base_uri' => 'https://oapi.dingtalk.com/',
        ],
    ];

    public function __call($method, $arguments)
    {
        return $this['base']->$method(...$arguments);
    }
}
