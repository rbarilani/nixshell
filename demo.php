<?php

use Nixshell\Shell;

require_once __DIR__ . '/vendor/autoload.php';

function header($header) {
    echo "\n\n" . $header;
}

$shell = new Shell();

$result = $shell->exec('ls');
var_dump($result);

try{
    $shell->exec('cat notexistent');
}catch (\Nixshell\Command\CommandResultException $e) {
    var_dump($e);
}

$history = $shell->getHistory();
var_dump($history);

exit;
