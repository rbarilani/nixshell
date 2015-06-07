<?php

namespace Nixshell;

use Nixshell\Command\CommandResultInterface;

interface ShellInterface {

    /**
     * @param string $command
     *
     * @return CommandResultInterface
     */
	public function exec($command);

    /**
     * Return number of commands executed by this shell
     *
     * @return int
     */
    public function getCount();

    /**
     * Return a list of commands executed by this shell
     *
     * @param int $n - return only a list of last $n commands
     * @return string[]
     */
    public function getHistory($n = 0);

    /**
     * Clear history
     *
     * @return void
     */
    public function clearHistory();
}
