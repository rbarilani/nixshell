<?php

namespace Nixshell\Command;

interface CommandExecutorInterface
{
    /**
     * @param string $command
     * @param array $output
     * @param int|null $exit_code
     * @return mixed
     */
    public function exec($command, array &$output = [], &$exit_code = null);
}