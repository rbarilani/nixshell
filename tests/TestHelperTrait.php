<?php

namespace Nixshell\Tests;


use Nixshell\Command\ExecutorInterface;

trait TestHelperTrait
{
    private $psr4namespace = "Nixshell\\";

    /**
     * @param string $class
     * @return string
     */
    public function getPsr4FullName($class)
    {
        return $this->psr4namespace . $class;
    }

    /**
     * @param bool $enabled
     * @return ExecutorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getExecutorMock($enabled = true)
    {
        /**
         * @var $this TestHelperTrait|\PHPUnit_Framework_TestCase
         */
        $mock = $this->getMock($this->getPsr4FullName('Command\ExecutorInterface'));
        $mock
            ->expects($this->once())
            ->method('isEnabled')
            ->willReturn($enabled);

        return $mock;
    }
}