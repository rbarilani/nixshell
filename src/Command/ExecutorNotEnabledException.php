<?php

namespace Nixshell\Command;

use Nixshell\ExecException;

/**
 * Class ExecutorNotEnabledException
 * @package Nixshell\Command
 */
class ExecutorNotEnabledException extends ExecException
{
    public function __construct($command, ExecutorInterface $executor)
    {
        $output = [
            sprintf('executor "%s" is not enabled', get_class($executor))
        ];
        parent::__construct($command, $output, 1);
    }

}