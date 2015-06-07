<?php

namespace Nixshell\Command;

trait CommandResultTrait
{
    private $exit_code;
    private $output;
    private $command;

    public function getExitCode()
    {
        return $this->exit_code;
    }

    public function getOutput()
    {
        return $this->output;
    }

    public function getCommand()
    {
        return $this->command;
    }
}
