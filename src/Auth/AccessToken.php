<?php
/**
 * This file is part of the dingtalk.
 * User: Ilham Tahir <yantaq@bilig.biz>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Aplisin\DingTalk\Auth;

use Aplisin\DingTalk\Kernel\AccessToken as BaseAccessToken;

class AccessToken extends BaseAccessToken
{
    protected $endpointToGetToken = '/gettoken';

    protected $safeSeconds = 0;

    protected function getCredentials(): array
    {
        return [
            'corpid' => $this->app['config']['corp_id'],
            'corpsecret' => $this->app['config']['secret'],
        ];
    }
}
