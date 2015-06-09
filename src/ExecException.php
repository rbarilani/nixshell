<?php

namespace Nixshell;

use Nixshell\Command\ResultInterface;
use Nixshell\Command\ResultTrait;

class ExecException extends \Exception implements ResultInterface
{
    use ResultTrait;

    /**
     * @param string $command
     * @param array $output
     * @param int $exit_code
     * @param \Exception $previous
     */
    public function __construct($command, array $output, $exit_code, \Exception $previous = NULL)
    {
        $this->command = $command;
        $this->output = $output;
        $this->exit_code = $exit_code;
        parent::__construct($this->buildMessage(), $this->getExitCode(), $previous);
    }

    /**
     * Build/compose the exception message
     * @return string
     */
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