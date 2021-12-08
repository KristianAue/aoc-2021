<?php
// Configuration file to make it easy for every day to import the necessary files

// Ensure that script is running in CLI
if (php_sapi_name() != 'cli') {
    exit('This script can only run from the command line.');
}

// Ensure memory limit is infinite
ini_set('memory_limit', -1);

// Check if file argument is set or not
$filename = isset($argv[1]) && $argv[1] === 'example' ? 'example.txt' : 'input.txt';

// Open file
$handle = fopen(getcwd(). '/' . $filename, 'r');

$lines = [];

if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $lines[] = rtrim($line, "\r\n");
    }

    fclose($handle);
}
