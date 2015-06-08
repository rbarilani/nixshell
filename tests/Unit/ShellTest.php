<?php

namespace Nixshell\Tests\Unit;
use Nixshell\Command\CommandResultException;
use Nixshell\Command\CommandResultInterface;
use Nixshell\Shell;

/**
 * Class ShellTest
 * @package Nixshell\Test
 */
class ShellTest extends \PHPUnit_Framework_TestCase
{
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
        $command = 'foo';
        $execLambdaStub = function ($command, &$output, &$exit_code) {
            $output = [];
            $exit_code = 0;
            $this->assertEquals('foo 2>&1', $command);
        };

        $this->shell->setExecLambda($execLambdaStub);

        $result = $this->shell->exec($command);
        $this->assertTrue($result instanceof CommandResultInterface);
    }

    public function testExecThrowsAnException()
    {
        $command = 'foo';

        $execLambdaStub = function ($command, &$output, &$exit_code) {
            $output = ['foo doesn\'t exists'];
            $exit_code = 1;
        };

        $this->shell->setExecLambda($execLambdaStub);

        try{
            $this->shell->exec($command);
        }catch (CommandResultException $e) {
            $this->assertEquals(['foo doesn\'t exists'], $e->getOutput());
            return;
        }

        $this->fail('It should throws a CommandResultException');
    }
}
