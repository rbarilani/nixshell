<?php

namespace Nixshell\Command;


/**
 * Class ExecutorNotEnabledException
 * @package Nixshell\Command
 */
class ExecutorNotEnabledException extends ResultException
{
    public function __construct($command, ExecutorInterface $executor)
    {
        $output = [
            sprintf('executor "%s" is not enabled', get_class($executor))
        ];
        parent::__construct($command, $output, 1);
    }

}