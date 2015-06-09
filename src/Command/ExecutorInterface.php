<?php

namespace Nixshell\Command;

/**
 * Represents an object that is able to execute commands
 *
 * Interface ExecutorInterface
 * @package Nixshell\Command
 */
interface ExecutorInterface
{
    /**
     * Execute a OS command
     *
     * @param string $command
     * @param array $output
     * @param int|null $exit_code
     * @return mixed
     */
    public function exec($command, array &$output = [], &$exit_code = null);

    /**
     * Check if the current executor is enabled (can do the job)
     * @return bool
     */
    public function isEnabled();
}