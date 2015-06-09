<?php

namespace Nixshell;

use Nixshell\Command\CommandExecutor;
use Nixshell\Command\CommandExecutorInterface;
use Nixshell\Command\CommandResult;
use Nixshell\Command\CommandResultException;
use Nixshell\Command\CommandResultInterface;

class Shell implements ShellInterface
{

    private $count = 0;
    private $history = [];
    private $executor;

    public function __construct(CommandExecutorInterface $executor = null)
    {
        $this->executor = $executor ? $executor : $this->createDefaultExecutor();
    }

    /**
     * @param string $command
     *
     * @return CommandResultInterface
     * @throws CommandResultException
     */
    public function exec($command)
    {
        $output = [];
        $exit_code = null;

        $this->executor->exec('(' . $command . ')' .' 2>&1', $output, $exit_code);

        $this->history[] = $command;
        $this->count = $this->count + 1;

        if ($exit_code !== 0) {
            throw new CommandResultException($command, $output, $exit_code);
        }
        return new CommandResult($command, $output, $exit_code);
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
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
     * @return void
     */
    public function clearHistory()
    {
        $this->history = [];
    }

    /**
     * @param CommandExecutorInterface $executor
     */
    public function setExecutor(CommandExecutorInterface $executor)
    {
        $this->executor = $executor;
    }

    /**
     * @return CommandExecutorInterface
     */
    protected function createDefaultExecutor() {
        return new CommandExecutor();
    }

}
