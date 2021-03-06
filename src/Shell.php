<?php

namespace Nixshell;

use Nixshell\Command\Executor;
use Nixshell\Command\ExecutorInterface;
use Nixshell\Command\ExecutorNotEnabledException;
use Nixshell\Command\Result;
use Nixshell\Command\ResultException;


/**
 * Class Shell
 * @package Nixshell
 */
class Shell implements ShellInterface
{
    private $history = [];
    private $executor;

    /**
     * @param null|ExecutorInterface $executor
     */
    public function __construct(ExecutorInterface $executor = null)
    {
        // optionally inject the executor, if null use the default one
        $this->executor = $executor ? $executor : $this->createDefaultExecutor();
    }

    /**
     * {@inheritdoc}
     *
     * @param string $command
     *
     * @return Result
     * @throws ResultException
     */
    public function exec($command)
    {
        $output = [];
        $exit_code = null;

        if($this->executor->isEnabled() === false) {
            throw new ExecutorNotEnabledException($command, $this->executor);
        }

        $this->executor->exec($command, $output, $exit_code);
        $this->onExecutedCommand($command);

        if ($exit_code !== 0) {
            throw new ResultException($command, $output, $exit_code);
        }

        return new Result($command, $output, $exit_code);
    }

    /**
     * @param int $n
     *
     * @return \string[]
     */
    public function getHistory($n = 0)
    {
        if (!$n) {
            return $this->history;
        }

        return array_slice($this->history, sizeof($this->history) - $n);
    }

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function clearHistory()
    {
        $this->history = [];
    }

    /**
     * Inject the executor
     *
     * @param ExecutorInterface $executor
     */
    public function setExecutor(ExecutorInterface $executor)
    {
        $this->executor = $executor;
    }

    /**
     * Instantiate the default executor
     *
     * @return ExecutorInterface
     */
    protected function createDefaultExecutor()
    {
        return new Executor();
    }

    /**
     * On executed command callback
     *
     * @param string $command
     */
    protected function onExecutedCommand($command)
    {
        $this->history[] = $command;
    }

}
