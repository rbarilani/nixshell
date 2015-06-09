<?php

namespace Nixshell\Command;

class ResultException extends \Exception implements ResultInterface
{

    use ResultTrait;

    public function __construct($command, $output, $exit_code, \Exception $previous = NULL)
    {
        $this->command = $command;
        $this->output = $output;
        $this->exit_code = $exit_code;
        parent::__construct($this->buildMessage(), $this->getExitCode(), $previous);
    }

    protected function buildMessage()
    {
        return sprintf(
            "%s (executed:'%s', exit code:%s)",
            join("\n", $this->getOutput()),
            $this->getCommand(),
            $this->getExitCode()
        );
    }
}
