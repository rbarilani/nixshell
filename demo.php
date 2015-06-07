<?php

use Nixshell\Shell;

require_once __DIR__ . '/vendor/autoload.php';

$shell = new Shell();

$result = $shell->exec('ls');

try {
    $shell->exec('cat notexistent');
} catch (\Nixshell\Command\CommandResultException $e) {

}

$history = $shell->getHistory();

exit;
