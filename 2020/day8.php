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
    if (!isset($instructions[$pointer])) {
        throw new DomainException($acc);
    }
    $cmd = $instructions[$pointer]['cmd'];
    $value = $instructions[$pointer]['value'];
    $currentPointer = $nextPointer = $pointer;
    if (in_array($pointer, $history, true)) {
        throw new RuntimeException($acc);
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
} catch (RuntimeException $exception) {
    dump($exception->getMessage());
}
$programs = [];
foreach ($instructions as $key => $instruction) {
    $cmd = $instruction['cmd'];
    if ($cmd === 'jmp') {
        $modified = $instructions;
        $modified[$key]['cmd'] = 'nop';
        $programs[] = $modified;
    }
    if ($cmd === 'nop') {
        $modified = $instructions;
        $modified[$key]['cmd'] = 'jmp';
        $programs[] = $modified;
    }
}

$accStep2 = 0;
$pointerStep2 = 0;
foreach ($programs as $program) {
    try {
        [$accStep2, $pointerStep2] = executeCmd($program, $accStep2, $pointerStep2);
    } catch (RuntimeException $exception) {
    } catch (DomainException $exception) {
        dump($exception->getMessage());
    }
}

die('hard');
