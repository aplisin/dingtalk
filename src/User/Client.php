<?php
/**
 * This file is part of the dingtalk.
 * User: Ilham Tahir <yantaq@bilig.biz>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Aplisin\DingTalk\User;

use Aplisin\DingTalk\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * @param array $params
     * @return \Aplisin\DingTalk\Kernel\Http\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function simpleList(array $params)
    {
        return $this->httpGet('/user/simplelist', $params);
    }
}
