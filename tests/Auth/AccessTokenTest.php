<?php
/**
 * This file is part of the dingtalk.
 * User: Ilham Tahir <yantaq@bilig.biz>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Aplisin\DingTalk\Tests\Auth;

use Aplisin\DingTalk\Kernel\ServiceContainer;
use Aplisin\DingTalk\Tests\BaseCase;
use Aplisin\DingTalk\Auth\AccessToken;

class AccessTokenTest extends BaseCase
{
    public function testGetCredentials()
    {
        $app = new ServiceContainer([
            'corp_id' => '1234',
            'secret' => 'secret',
        ]);

        $accessToken = \Mockery::mock(AccessToken::class, [$app])->makePartial()->shouldAllowMockingProtectedMethods();
        $this->assertSame([
            'corpid' => '1234',
            'corpsecret' => 'secret',
        ], $accessToken->getCredentials());
    }

    public function testEndpoint()
    {
        $this->assertSame('/gettoken', (new AccessToken(new ServiceContainer()))->getEndpoint());
    }
}
