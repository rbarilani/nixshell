<?php

namespace Nixshell\Command;


class CommandExecutor implements CommandExecutorInterface
{

    /**
     * @param string $command
     * @param array $output
     * @param int|null $exit_code
     * @return mixed
     */
    public function exec($command, array &$output = [], &$exit_code = null)
    {
        return exec($command, $output, $exit_code);
    }
}