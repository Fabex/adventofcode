<?php
require 'vendor/autoload.php';

$fileContent = file_get_contents('day8.txt');
$results = [];
$instructions = [];
preg_match_all('/(\w{3}) ([+-]\d+)\n/', $fileContent, $results);

foreach ($results[1] as $key => $inst) {
    $instructions[] = ['cmd' => $inst, 'value' => $results[2][$key]];
}

function executeCmd(array &$instructions, int $acc, int $pointer, array $history = [], bool $modified = false)
{
    $cmd = $instructions[$pointer]['cmd'];
    $value = $instructions[$pointer]['value'];
    $currentPointer = $nextPointer = $pointer;
    if (in_array($pointer, $history)) {
        throw new Exception($acc);
    }
    $history[] = $pointer;
    switch ($cmd) {
        case 'acc':
            eval("\$acc = $acc.$value;");
            $nextPointer = $currentPointer + 1;
            break;
        case 'jmp':
            eval("\$nextPointer = $currentPointer.$value;");
            break;
        case 'nop':
            $nextPointer = $currentPointer + 1;
            break;
    }
    [$acc, $pointer] = executeCmd($instructions, $acc, $nextPointer, $history, $modified);

    return [$acc, $pointer];
}

$acc = 0;
$pointer = 0;
try {
    [$acc, $pointer] = executeCmd($instructions, $acc, $pointer);
    dump($acc);
    dump('rrr');
} catch (Exception $exception) {
    dump($exception->getMessage());
    dump('aaa');
}

die('hard');
