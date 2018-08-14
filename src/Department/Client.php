<?php
/**
 * This file is part of the dingtalk.
 * User: Ilham Tahir <yantaq@bilig.biz>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Aplisin\DingTalk\Department;

use Aplisin\DingTalk\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * @param int $id
     * @return \Aplisin\DingTalk\Kernel\Http\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function listIds($id = 1)
    {
        return $this->httpGet('/department/list_ids', compact('id'));
    }

    /**
     * @param int $id
     * @param bool $fetchChild
     * @param string $lang
     * @return \Aplisin\DingTalk\Kernel\Http\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function list($id = 1, $fetchChild = false, $lang = 'zh_CN')
    {
        $params = [
            'id' => $id,
            'fetch_child' => $fetchChild,
            'lang' => $lang
        ];
        return $this->httpGet('/department/list', $params);
    }

    /**
     * @param int $id
     * @param string $lang
     * @return \Aplisin\DingTalk\Kernel\Http\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(int $id, $lang = 'zh_CN')
    {
        $params = [
            'id' => $id,
            'lang' => $lang
        ];
        return $this->httpGet('/department/get', $params);
    }

    /**
     * @param array $data
     * @return \Aplisin\DingTalk\Kernel\Http\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(array $data)
    {
        return $this->httpPostJson('/department/create', $data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return \Aplisin\DingTalk\Kernel\Http\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(int $id, array $data)
    {
        return $this->httpPostJson('/department/update', array_merge(compact('id'), $data));
    }
}
