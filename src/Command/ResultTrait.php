<?php

namespace Nixshell\Command;

/**
 * Class ResultTrait
 * @package Nixshell\Command
 */
trait ResultTrait
{
    private $exit_code;
    private $output;
    private $command;

    /**
     * @return null|int
     */
    public function getExitCode()
    {
        return $this->exit_code;
    }

    /**
     * @return array
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }
}
