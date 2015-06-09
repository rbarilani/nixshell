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

    /**
     * @dataProvider execDataProvider
     *
     * @param $command
     * @param array $stubOutput
     * @param int $stubExitCode
     * @return CommandResultInterface
     * @throws CommandResultException
     */
    public function testExec($command, array $stubOutput = [], $stubExitCode = 0)
    {
        $executorStub = $this->getMock($this->getPsr4FullName('Command\CommandExecutorInterface'));
        $executorStub
            ->expects($this->once())
            ->method('exec')
            ->with('('.$command.') 2>&1')
            ->willReturnCallback(function ($command, &$output = [], &$exit_code = null) use ($stubOutput, $stubExitCode){
                $output = $stubOutput;
                $exit_code = $stubExitCode;
            });
        $this->shell->setExecutor($executorStub);

        $result = $this->shell->exec($command);
        $this->assertTrue($result instanceof CommandResultInterface);

        return $result;
    }

    /**
     * @dataProvider execDataProvider
     * @param string $command
     * @param array $output
     */
    public function testExecResult($command, array $output = [])
    {
        $result = $this->testExec($command, $output);
        $this->assertEquals($command, $result->getCommand());
        $this->assertEquals($output, $result->getOutput());
        $this->assertEquals(0, $result->getExitCode());
    }

    public function execDataProvider()
    {
        return [
            ['foo', ['great']]
        ];
    }

    /**
     * @dataProvider execExceptionDataProvider
     * @param string $command
     * @param array $stubOutput
     * @return \Exception|CommandResultException
     */
    public function testExecThrowsAnException($command, array $stubOutput = [])
    {
        $executorStub = $this->getMock($this->getPsr4FullName('Command\CommandExecutorInterface'));
        $executorStub
            ->expects($this->once())
            ->method('exec')
            ->with('('. $command. ') 2>&1')
            ->willReturnCallback(function ($command, &$output = [], &$exit_code = null) use ($stubOutput) {
                $output = $stubOutput;
                $exit_code = 1;
            });
        $this->shell->setExecutor($executorStub);

        try{
            $this->shell->exec($command);
        }catch (CommandResultException $e) {
            $this->assertInstanceOf($this->getPsr4FullName('Command\CommandResultInterface'), $e);
            $this->assertEquals($stubOutput, $e->getOutput());
            return $e;
        }

        $this->fail('It should throws a CommandResultException');
    }

    /**
     * @dataProvider execExceptionDataProvider
     * @param string $command
     * @param array $output
     */
    public function testExecExceptionResult($command, array $output = [])
    {
        $e = $this->testExecThrowsAnException($command, $output);
        $this->assertEquals($command, $e->getCommand());
        $this->assertEquals($output, $e->getOutput());
        $this->assertEquals(1, $e->getExitCode());
    }

    public function execExceptionDataProvider()
    {
        return [
            ['foo', ['foo doesn\'t exist']]
        ];
    }


}
