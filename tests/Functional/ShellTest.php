<?php

namespace Nixshell\Tests\Functional;
use Nixshell\Command\ResultException;
use Nixshell\Command\ResultInterface;
use Nixshell\Shell;
use Nixshell\ShellInterface;

/**
 * Class ShellTest
 * @package Nixshell\Test
 */
class ShellTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ShellInterface
     */
    protected $shell;

    public function setUp()
    {
        $this->shell = new Shell();
    }

    public function testExec()
    {
        $command = 'ls *.json';
        $result = $this->shell->exec($command);
        $this->assertTrue($result instanceof ResultInterface);
    }

    /**
     * @dataProvider execResultProvider
     *
     * @param $command
     * @param $expectedExitCode
     * @param $expectedOutput
     */
    public function testExecResult($command, $expectedExitCode, $expectedOutput = null)
    {
        try{
            $result = $this->shell->exec($command);
        }catch (ResultException $e) {
            $result = $e;
        }

        $this->assertEquals($command, $result->getCommand());
        $this->assertEquals($expectedExitCode, $result->getExitCode());

        if($expectedOutput !== null) {
            $this->assertEquals($result->getOutput(), $expectedOutput);
        }
    }

    public function execResultProvider()
    {
        return [
          ['ls *.json', 0, [ 'composer.json' ] ],
          ['cat not.existent', 1 ]
        ];
    }
}
