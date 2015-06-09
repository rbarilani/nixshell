<?php

namespace Nixshell\Tests\Unit;
use Nixshell\Command\CommandResultException;
use Nixshell\Command\CommandResultInterface;
use Nixshell\Shell;
use Nixshell\Tests\CommonTestHelperTrait;

/**
 * Class ShellTest
 * @package Nixshell\Test
 */
class ShellTest extends \PHPUnit_Framework_TestCase
{
    use CommonTestHelperTrait;

    /**
     * @var Shell
     */
    protected $shell;

    public function setUp()
    {
        $this->shell = new Shell();
    }

    public function testExec()
    {
        $executorStub = $this->getMock($this->getPsr4FullName('Command\CommandExecutorInterface'));
        $executorStub
            ->expects($this->once())
            ->method('exec')
            ->with('foo 2>&1', [], null)
            ->willReturnCallback(function ($command, &$output = [], &$exit_code = null) {
                $output = [];
                $exit_code = 0;
            });
        $this->shell->setExecutor($executorStub);

        $this->assertTrue($this->shell->exec('foo') instanceof CommandResultInterface);
    }

    public function testExecThrowsAnException()
    {
        $executorStub = $this->getMock($this->getPsr4FullName('Command\CommandExecutorInterface'));
        $executorStub
            ->expects($this->once())
            ->method('exec')
            ->with('foo 2>&1')
            ->willReturnCallback(function ($command, &$output = [], &$exit_code = null) {
                $output = ['foo doesn\'t exist'];
                $exit_code = 1;
            });
        $this->shell->setExecutor($executorStub);

        try{
            $this->shell->exec('foo');
        }catch (CommandResultException $e) {
            $this->assertInstanceOf($this->getPsr4FullName('Command\CommandResultInterface'), $e);
            $this->assertEquals(['foo doesn\'t exist'], $e->getOutput());
            return;
        }

        $this->fail('It should throws a CommandResultException');
    }
}
