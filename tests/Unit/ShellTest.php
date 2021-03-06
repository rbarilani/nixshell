<?php

namespace Nixshell\Tests\Unit;
use Nixshell\Command\ExecutorNotEnabledException;
use Nixshell\Command\ResultException;
use Nixshell\Command\ResultInterface;
use Nixshell\ExecException;
use Nixshell\Shell;
use Nixshell\Tests\TestHelperTrait;

/**
 * Class ShellTest
 * @package Nixshell\Test
 */
class ShellTest extends \PHPUnit_Framework_TestCase
{
    use TestHelperTrait;

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
     * @return ResultInterface
     * @throws ResultException
     */
    public function testExec($command, array $stubOutput = [], $stubExitCode = 0)
    {
        $executorMock = $this->getExecutorMock();
        $executorMock
            ->expects($this->once())
            ->method('exec')
            ->with($command)
            ->willReturnCallback(function ($command, &$output = [], &$exit_code = null) use ($stubOutput, $stubExitCode){
                $output = $stubOutput;
                $exit_code = $stubExitCode;
            });
        $this->shell->setExecutor($executorMock);

        $result = $this->shell->exec($command);
        $this->assertTrue($result instanceof ResultInterface);

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
     * @return \Exception|\Nixshell\ExecException
     */
    public function testExecThrowsAnException($command, array $stubOutput = [])
    {
        $executorMock = $this->getExecutorMock();
        $executorMock
            ->expects($this->once())
            ->method('exec')
            ->with($command)
            ->willReturnCallback(function ($command, &$output = [], &$exit_code = null) use ($stubOutput) {
                $output = $stubOutput;
                $exit_code = 1;
            });
        $this->shell->setExecutor($executorMock);

        try{
            $this->shell->exec($command);
        }catch (ExecException $e) {
            $this->assertInstanceOf($this->getPsr4FullName('Command\ResultInterface'), $e);
            $this->assertEquals($stubOutput, $e->getOutput());
            return $e;
        }

        $this->fail('It should throws a ResultException');
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

    public function testExecExecutorNotEnabledException()
    {
        $executorMock = $this->getExecutorMock(false);

        $executorMock
            ->expects($this->never())
            ->method('exec');

        $this->shell->setExecutor($executorMock);

        try{
            $this->shell->exec('ls');
        }catch (ExecutorNotEnabledException $e) {
            $this->assertRegExp('/^executor \"Mock_ExecutorInterface_.*\" is not enabled/', $e->getMessage());
            $this->assertInstanceOf($this->getPsr4FullName('Command\ResultInterface'), $e);
            return $e;
        }

        $this->fail('It should throws a ExecutorNotEnabledException');
    }

    public function testGetHistory()
    {
        $this->testExec('ls');
        $this->testExecExceptionResult('cat d');
        $this->assertEquals(['ls','cat d'], $this->shell->getHistory());
    }

    public function testGetHistorySlice()
    {
        $this->testExec('ls');
        $this->testExecExceptionResult('cat d');
        $this->testExecExceptionResult('vi conf');
        $this->testExec('echo hello');

        $this->assertEquals(['vi conf','echo hello'], $this->shell->getHistory(2));
    }

    public function testClearHistory()
    {
        $this->testExec('ls');
        $this->testExecExceptionResult('cat d');
        $this->assertNotEmpty($this->shell->getHistory());

        $this->shell->clearHistory();

        $this->assertEmpty($this->shell->getHistory());
    }

}
