<?php

namespace Nixshell\Command;

/**
 * Represents a successful result of an executed command
 *
 * Class Result
 * @package Nixshell\Command
 */
class Result implements ResultInterface
{
    use ResultTrait;

    /**
     * @param string $command
     * @param array $output
     * @param int $exit_code
     */
    public function __construct($command, array $output, $exit_code)
    {
        $this->command = $command;
        $this->output = $output;
        $this->exit_code = $exit_code;
    }
}
