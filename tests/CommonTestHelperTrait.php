<?php

namespace Nixshell\Tests;


trait CommonTestHelperTrait
{
    private $psr4namespace = "Nixshell\\";

    public function getPsr4FullName($class)
    {
        return $this->psr4namespace . $class;
    }
}