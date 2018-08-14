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

    public function testList()
    {
        $client = $this->mockApiClient(Client::class);
        $client->expects()->httpGet('/department/list', [
            'id' => 1,
            'fetch_child' => false,
            'lang' => 'zh_CN'
        ])->andReturn('mock-result')->once();
        $this->assertSame('mock-result', $client->list(1));
    }

    public function testGet()
    {
        $client = $this->mockApiClient(Client::class);
        $client->expects()->httpGet('/department/get', [
            'id' => 1,
            'lang' => 'zh_CN'
        ])->andReturn('mock-result')->once();
        $this->assertSame('mock-result', $client->get(1));
    }

    public function testCreate()
    {
        $client = $this->mockApiClient(Client::class);
        $client->expects()->httpPostJson('/department/create', [
            'name' => 'test Dep',
            'parentid' => 1
        ])->andReturn('mock-result')->once();
        $this->assertSame('mock-result', $client->create([
            'name' => 'test Dep',
            'parentid' => 1
        ]));
    }

    public function testUpdate()
    {
        $client = $this->mockApiClient(Client::class);
        $client->expects()->httpPostJson('/department/update', [
            'name' => 'test Dep',
            'id' => 1
        ])->andReturn('mock-result')->once();
        $this->assertSame('mock-result', $client->update(1, [
            'name' => 'test Dep',
        ]));
    }
}
