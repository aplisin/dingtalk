<?php
/**
 * This file is part of the dingtalk.
 * User: Ilham Tahir <yantaq@bilig.biz>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Aplisin\DingTalk\Tests\Department;

use Aplisin\DingTalk\Department\Client;
use Aplisin\DingTalk\Tests\BaseCase;

class ClientTest extends BaseCase
{
    public function testListIds()
    {
        $client = $this->mockApiClient(Client::class);
        $client->expects()->httpGet('/department/list_ids', [
            'id' => 1
        ])->andReturn('mock-result')->once();
        $this->assertSame('mock-result', $client->listIds(1));
    }
}
