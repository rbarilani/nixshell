<?php

namespace Nixshell\Command;

class Result implements ResultInterface
{
    use ResultTrait;

    public function __construct($command, $output, $exit_code)
    {
        $this->command = $command;
        $this->output = $output;
        $this->exit_code = $exit_code;
    }
}
