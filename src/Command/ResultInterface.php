<?php

namespace Nixshell\Command;

/**
 * Represents a result of an executed command
 *
 * Interface ResultInterface
 * @package Nixshell\Command
 */
interface ResultInterface
{
    /**
     * Command exit code
     * @return int
     */
    public function getExitCode();

    /**
     * Command output
     * @return array
     */
    public function getOutput();

    /**
     * Command executed
     * @return string
     */
    public function getCommand();
}
