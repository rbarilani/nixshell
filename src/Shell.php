<?php

namespace Nixshell;

use Nixshell\Command\CommandResult;
use Nixshell\Command\CommandResultException;
use Nixshell\Command\CommandResultInterface;

class Shell implements ShellInterface
{

    private $count = 0;
    private $history = [];
    private $execLambda;

    public function __construct(callable $execLambda = null)
    {
        $this->execLambda = $execLambda ? $execLambda : $this->getDefaultExecLambda();
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

        $execLambda = $this->execLambda;
        $execLambda($command . ' 2>&1', $output, $exit_code);

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
     * @param callable $execLambda
     */
    public function setExecLambda(callable $execLambda)
    {
        $this->execLambda = $execLambda;
    }

    /**
     * @return callable
     */
    protected function getDefaultExecLambda() {
        /**
         * @param $command
         * @param array $output
         * @param int|null $exit_code
         *
         * @return string
         */
        return function ($command, array &$output = [], &$exit_code = null) {
            return exec($command, $output, $exit_code);
        };
    }

}
