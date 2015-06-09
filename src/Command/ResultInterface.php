<?php

namespace Nixshell\Command;

interface ResultInterface
{
    public function getExitCode();

    public function getOutput();

    public function getCommand();
}
