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
     * @return \Aplisin\DingTalk\Kernel\Http\Response|\Aplisin\DingTalk\Kernel\Support\Collection|array|mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function listIds($id = 1)
    {
        return $this->httpGet('/department/list_ids', compact('id'));
    }
}
