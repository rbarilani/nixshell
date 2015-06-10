rbarilani/nixshell
==================

A minimalistic php object oriented ```exec``` wrap.

[![Build Status](https://travis-ci.org/rbarilani/nixshell.svg)](https://travis-ci.org/rbarilani/nixshell)
[![Code Coverage](https://scrutinizer-ci.com/g/rbarilani/nixshell/badges/coverage.png)](https://scrutinizer-ci.com/g/rbarilani/nixshell)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/rbarilani/nixshell/badges/quality-score.png)](https://scrutinizer-ci.com/g/rbarilani/nixshell)

## Install

Adds this to your composer.json and run ```composer update rbarilani/nixshell```:

```json
{
    "require": {
        "rbarilani/nixshell" : "dev-master"
    },
    "repositories" : [
        { "type":"git", "url":"https://github.com/rbarilani/nixshell.git" }
    ]
}   
```

## Usage

```php
<?php

require_once ('vendor/autoload.php');

use Nixshell\Shell;
use Nixshell\ExecException;

$shell  = new Shell();

// successful command
$result = $shell->exec('ls');

$result->getExitCode(); // 0
$result->getOutput();   // ["dir1","dir2","etc"]


// unsuccessful command
try {
    $shell->exec('cat not-existent-file');

}catch(ExecException $e) {

    $e->getExitCode(); // 1
    $e->getMessage();  // "cat: not-existent-file: No such file or directory (executed:'cat not-existent-file', exit code:1)"
    $e->getOutput();   // [""cat: not-existent-file: No such file or directory"]
}

// history
$shell->getHistory(); // ["ls","cat not-existent-file"]

// clear history
$shell->clearHistory(); // []

```

## Development

Contributions are highly welcome.
Just clone the repository and submit your contributions as pull requests.

