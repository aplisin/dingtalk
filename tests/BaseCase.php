<?php
/**
 * This file is part of the dingtalk.
 * User: Ilham Tahir <yantaq@bilig.biz>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Aplisin\DingTalk\Tests;

use Aplisin\DingTalk\Kernel\ServiceContainer;
use Aplisin\DingTalk\Kernel\AccessToken;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class BaseCase extends BaseTestCase
{

    /**
     * @param $name
     * @param array $methods
     * @param ServiceContainer|null $app
     * @return \Mockery\Mock
     */
    public function mockApiClient($name, $methods = [], ServiceContainer $app = null)
    {
        $methods = implode(',', array_merge([
            'httpGet', 'httpPost', 'httpPostJson', 'httpUpload',
            'request', 'requestRaw', 'registerMiddlewares',
        ], (array) $methods));

        $client = \Mockery::mock(
            $name."[{$methods}]",
            [$app ?? \Mockery::mock(ServiceContainer::class),
                \Mockery::mock(AccessToken::class), ]
        )->shouldAllowMockingProtectedMethods();
        $client->allows()->registerHttpMiddlewares()->andReturnNull();

        return $client;
    }

    public function tearDown()
    {
        parent::tearDown();
        if ($container = \Mockery::getContainer()) {
            $this->addToAssertionCount($container->Mockery_getExpectationCount());
        }
        \Mockery::close();
    }
}
