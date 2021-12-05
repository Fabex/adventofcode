<?php
require __DIR__ . '/../vendor/autoload.php';

$instructions = file('day5.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$instructions = array_map(static fn($line) => explode(' -> ', $line), $instructions);

$matrix = [];

function drawVertical(&$matrix, $startX, $startY, $endY)
{
    $start = min($startY, $endY);
    $end = max($startY, $endY);

    for (; $start <= $end; $start++) {
        $idx = $startX . '-' . $start;
        $matrix[$idx] = isset($matrix[$idx]) ? $matrix[$idx] + 1 : 1;
    }
}

function drawHorizontal(&$matrix, $startY, $startX, $endX)
{
    $start = min($startX, $endX);
    $end = max($startX, $endX);

    for (; $start <= $end; $start++) {
        $idx = $start . '-' . $startY;
        $matrix[$idx] = isset($matrix[$idx]) ? $matrix[$idx] + 1 : 1;
    }
}

function drawDiag(&$matrix, $startX, $startY, $endX, $endY)
{
    if ($startX < $endX) {
        for (; $startX <= $endX; $startX++) {
            $idx = $startX . '-' . ($startY < $endY ? $startY++ : $startY--);
            $matrix[$idx] = isset($matrix[$idx]) ? $matrix[$idx] + 1 : 1;
        }
        return;
    }

    if ($startX > $endX) {
        for (; $startX >= $endX; $startX--) {
            $idx = $startX . '-' . ($startY < $endY ? $startY++ : $startY--);
            $matrix[$idx] = isset($matrix[$idx]) ? $matrix[$idx] + 1 : 1;
        }
        return;
    }
}

foreach ($instructions as $instruction) {
    [$startX, $startY] = explode(',', $instruction[0]);
    [$endX, $endY] = explode(',', $instruction[1]);
    if ($startX === $endX) {
        drawVertical($matrix, (int)$startX, (int)$startY, (int)$endY);
        continue;
    }
    if ($startY === $endY) {
        drawHorizontal($matrix, (int)$startY, (int)$startX, (int)$endX);
        continue;
    }
    //step1 remove line below
    drawDiag($matrix, (int)$startX, (int)$startY, (int)$endX, (int)$endY);
}
$t = [];
foreach ($matrix as $coord => $value) {
    [$x, $y] = explode('-', $coord);
    $t[$x][$y] = $value;
}

foreach ($t as $i => $v) {
    $t[$i] = $v + array_fill_keys(range(min(array_keys($v)), max(array_keys($v))), ' ');
    ksort($t[$i]);
}

$u = $t + array_fill_keys(range(min(array_keys($t)), max(array_keys($t))), '');

ksort($u);
foreach ($u as $v) {
    foreach ($v as $i) {
        echo match ((string)$i) {
            ' ' => " ",
            '1' => "\e[96m*\e[0m",
            '2' => "\e[94m*\e[0m",
            '3' => "\e[92m*\e[0m",
            '4' => "\e[93m*\e[0m",
            '5' => "\e[91m*\e[0m",
        };
    }
    echo "\n";
}
dump(count(array_filter($matrix, static fn($item) => $item >= 2)));

