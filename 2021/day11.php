<?php
require __DIR__ . '/../vendor/autoload.php';

$lines = array_map(static fn($line) => str_split($line), file('day11.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));

$octopuses = [];

foreach ($lines as $y => $line) {
    foreach ($line as $x => $value) {
        $adjacent = [];
        if (isset($lines[$y - 1][$x - 1])) {
            $adjacent['tl'] = ($x - 1) . '-' . ($y - 1);
        }
        if (isset($lines[$y - 1][$x])) {
            $adjacent['t'] = ($x) . '-' . ($y - 1);
        }
        if (isset($lines[$y - 1][$x + 1])) {
            $adjacent['tr'] = ($x + 1) . '-' . ($y - 1);
        }
        if (isset($line[$x - 1])) {
            $adjacent['l'] = ($x - 1) . '-' . ($y);
        }
        if (isset($line[$x + 1])) {
            $adjacent['r'] = ($x + 1) . '-' . ($y);
        }
        if (isset($lines[$y + 1][$x - 1])) {
            $adjacent['bl'] = ($x - 1) . '-' . ($y + 1);
        }
        if (isset($lines[$y + 1][$x])) {
            $adjacent['b'] = ($x) . '-' . ($y + 1);
        }
        if (isset($lines[$y + 1][$x + 1])) {
            $adjacent['br'] = ($x + 1) . '-' . ($y + 1);
        }
        $octopuses["$x-$y"] = [
            'value' => (int)$value,
            'flashed' => false,
            'adjacent' => $adjacent,
        ];
    }
}

function display(array $octopuses)
{
    usleep(10000);
    system('clear');
    $chunks = array_chunk($octopuses, 10);
    foreach ($chunks as $chunk) {
        foreach ($chunk as $octopus) {
            $value = $octopus['value'] > 9 ? 0 : $octopus['value'];
            if ($octopus['flashed']) {
                echo "\e[92m{$value}\e[0m";
                continue;
            }
            echo $value;
        }
        echo "\n";
    }
}

function runStep(array &$octopuses, array $works, int &$totalFlash)
{
    foreach ($works as $idx => $work) {
        if (false === $octopuses[$idx]['flashed']) {
            $octopuses[$idx]['value']++;
        }
    }
    foreach ($works as $idx => $work) {
        if ($octopuses[$idx]['value'] > 9) {
            $octopuses[$idx]['value'] = 0;
            if (false === $octopuses[$idx]['flashed']) {
                display($octopuses);
                $totalFlash++;
                $octopuses[$idx]['flashed'] = true;
                $propagation = [];
                foreach ($octopuses[$idx]['adjacent'] as $adjacent) {
                    $propagation[$adjacent] = $octopuses[$adjacent];
                }
                runStep($octopuses, $propagation, $totalFlash);
            }
        }
    }
}

$totalFlash = 0;
$step = 1;
do {
    runStep($octopuses, $octopuses, $totalFlash);
    $flashes = array_column($octopuses, 'flashed');
    if (count(array_filter($flashes, static fn($flash) => $flash === true)) === 100) {
        display($octopuses);
        dump($step);
        die();
    }
    foreach ($octopuses as &$octopus) {
        $octopus['flashed'] = false;
    }
    unset($octopus);
    $step++;
} while (true);
