<?php
require __DIR__ . '/../vendor/autoload.php';

$lines = file('day9.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($lines as &$line) {
    $values = str_split($line);
    $r = [];
    foreach ($values as $value) {
        $r[] = ['value' => (int)$value, 'selected' => false, 'basin' => ['value' => false, 'color' => null]];
    }
    $line = $r;
}
unset($line);
$step1 = 0;
foreach ($lines as $y => $line) {
    foreach ($line as $x => $value) {
        // up
        if (isset($lines[$y - 1][$x]) && $value['value'] >= $lines[$y - 1][$x]['value']) {
            continue;
        }
        // down
        if (isset($lines[$y + 1][$x]) && $value['value'] >= $lines[$y + 1][$x]['value']) {
            continue;
        }
        // left
        if (isset($line[$x - 1]) && $value['value'] >= $line[$x - 1]['value']) {
            continue;
        }
        // right
        if (isset($line[$x + 1]) && $value['value'] >= $line[$x + 1]['value']) {
            continue;
        }
        $lines[$y][$x]['selected'] = true;
        $step1 += $lines[$y][$x]['value'] + 1;
    }
}

function findRight(int $x, int $y, array &$lines, array &$basins, int $originalX = null, int $originalY = null): void
{
    $originalX = $originalX ?? $x;
    $originalY = $originalY ?? $y;
    do {
        if (!isset($lines[$y][$x]) || $lines[$y][$x]['value'] === 9) {
            break;
        }
        if (!$lines[$y][$x]['basin']['value']) {
            $basins["$originalX-$originalY"]++;
            $lines[$y][$x]['basin']['value'] = true;
            $lines[$y][$x]['basin']['color'] = $lines[$originalY][$originalX]['basin']['color'];
            findRight($x, $y+1, $lines, $basins, $originalX, $originalY);
            findRight($x, $y-1, $lines, $basins, $originalX, $originalY);
            findLeft($x, $y+1, $lines, $basins, $originalX, $originalY);
            findLeft($x, $y-1, $lines, $basins, $originalX, $originalY);
        }
        $x++;
    } while (true);
}

function findLeft(int $x, int $y, array &$lines, array &$basins, int $originalX = null, int $originalY = null): void
{
    $originalX = $originalX ?? $x;
    $originalY = $originalY ?? $y;
    do {
        if (!isset($lines[$y][$x]) || $lines[$y][$x]['value'] === 9) {
            break;
        }
        if (!$lines[$y][$x]['basin']['value']) {
            $basins["$originalX-$originalY"]++;
            $lines[$y][$x]['basin']['value'] = true;
            $lines[$y][$x]['basin']['color'] = $lines[$originalY][$originalX]['basin']['color'];
            findRight($x, $y+1, $lines, $basins, $originalX, $originalY);
            findRight($x, $y-1, $lines, $basins, $originalX, $originalY);
            findLeft($x, $y+1, $lines, $basins, $originalX, $originalY);
            findLeft($x, $y-1, $lines, $basins, $originalX, $originalY);
        }
        $x--;
    } while (true);
}
//88 123 35
$color = [91,92,93,95,96];
$colorInc = 0;
$basins = [];
foreach ($lines as $y => $line) {
    foreach ($line as $x => $value) {
        if ($value['selected']) {
            $basins["$x-$y"] = 0;
            $lines[$y][$x]['basin']['color'] = $color[$colorInc++ % count($color)];
            $lines[$y][$x]['basin']['value'] = false;
            findRight($x, $y, $lines, $basins);
            findLeft($x, $y, $lines, $basins);
        }
    }
}

foreach ($lines as $y => $line) {
    foreach ($line as $x => $value) {
        if ($value['selected']) {
            echo "\e[94m" . $value['value'] . "\e[0m";
            continue;
        }
        if ($value['basin']) {
            if($value['basin']['color'] !== null) {
                echo "\e[" . $value['basin']['color'] . "m" . $value['value'] . "\e[0m";
                continue;
            }
        }
        echo $value['value'];
    }
    echo "\n";
}
dump($step1);

//1079100 to low
rsort($basins);
$step2 = $basins[0] * $basins[1] * $basins[2];
dump($step2);
