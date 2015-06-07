<?php

namespace Nixshell\Command;

interface CommandResultInterface
{
    public function getExitCode();

    public function getOutput();

    public function getCommand();
}
