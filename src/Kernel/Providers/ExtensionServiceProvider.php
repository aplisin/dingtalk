<?php
/**
 * This file is part of the dingtalk.
 * User: Ilham Tahir <yantaq@bilig.biz>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Aplisin\DingTalk\Kernel\Providers;

use Pimple\ServiceProviderInterface;
use Pimple\Container;
use EasyWeChatComposer\Extension;

class ExtensionServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['extension'] = function ($app) {
            return new Extension($app);
        };
    }
}
