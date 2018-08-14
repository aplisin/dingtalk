<?php
/**
 * This file is part of the dingtalk.
 * User: Ilham Tahir <yantaq@bilig.biz>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Aplisin\DingTalk\Tests;

use Aplisin\DingTalk\Application;
use Aplisin\DingTalk\Auth\AccessToken;

class ApplicationTest extends BaseCase
{
    public function testInstances()
    {
        $app = new Application([
            'corp_id' => 'xwnaka223',
            'agent_id' => 102093,
            'secret' => 'secret',
        ]);

        $this->assertInstanceOf(AccessToken::class, $app->access_token);
    }
}