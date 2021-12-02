<?php
$instructions = file('day2.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

function step1(array $instructions): int
{
    $horizontal = 0;
    $depth = 0;
    foreach ($instructions as $instruction) {
        [$direction, $value] = explode(' ', $instruction);
        switch ($direction) {
            case 'down':
                $depth += (int) $value;
                break;
            case 'up':
                $depth -= (int) $value;
                break;
            case 'forward':
                $horizontal += (int) $value;
                break;
        }
    }

    return $depth * $horizontal;
}

function step2(array $instructions): int
{
    $horizontal = 0;
    $depth = 0;
    $aim = 0;
    foreach ($instructions as $instruction) {
        [$direction, $value] = explode(' ', $instruction);
        switch ($direction) {
            case 'down':
                $aim += (int) $value;
                break;
            case 'up':
                $aim -= (int) $value;
                break;
            case 'forward':
                $horizontal += (int) $value;
                $depth += (int) $value * $aim;
                break;
        }
    }

    return $depth * $horizontal;
}

var_dump(step1($instructions));
var_dump(step2($instructions));
