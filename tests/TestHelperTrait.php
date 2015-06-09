<?php

namespace Nixshell\Tests;


use Nixshell\Command\ExecutorInterface;

trait TestHelperTrait
{
    private $psr4namespace = "Nixshell\\";

    public function getPsr4FullName($class)
    {
        return $this->psr4namespace . $class;
    }

    /**
     * @param $command
     * @return \PHPUnit_Framework_MockObject_MockObject|ExecutorInterface
     */
    protected function getExecutorBaseStub($command, $enabled = true)
    {
        /**
         * @var $this TestHelperTrait|\PHPUnit_Framework_TestCase
         */
        $executorStub = $this->getMock($this->getPsr4FullName('Command\ExecutorInterface'));
        $executorStub
            ->expects($this->once())
            ->method('isEnabled')
            ->willReturn($enabled);

        return $executorStub;
    }
}