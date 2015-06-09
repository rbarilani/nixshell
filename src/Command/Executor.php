<?php

namespace Nixshell\Command;


/**
 * Default executor that wraps php exec function
 *
 * Class Executor
 * @package Nixshell\Command
 */
class Executor implements ExecutorInterface
{
    /**
     * Execute a OS command
     *
     * @param string $command
     * @param array $output
     * @param int|null $exit_code
     * @return mixed
     */
    public function exec($command, array &$output = [], &$exit_code = null)
    {
        // wraps command into rounded parenthesis to redirect the output (stderror to stdout)
        return exec('(' . $command . ')' .' 2>&1', $output, $exit_code);
    }
}