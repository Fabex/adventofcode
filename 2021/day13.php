<?php
require __DIR__ . '/../vendor/autoload.php';

$lines = file('day13.txt');

$coords = [];
$folds = [];
$xmax = $ymax = 0;

$isFolds = false;
foreach ($lines as $line) {
    $line = trim($line);
    if ($line === '') {
        $isFolds = true;
        continue;
    }
    if ($isFolds) {
        preg_match('/([x|y])=(\d+)/', $line, $result);
        $folds[] = ['axe' => $result[1], 'value' => (int)$result[2]];
        continue;
    }
    [$x, $y] = explode(',', $line);
    if ((int)$x > $xmax) {
        $xmax = (int)$x;
    }
    if ((int)$y > $ymax) {
        $ymax = (int)$y;
    }
    $coords[] = $line;
}
$map = array_fill(0, $ymax + 1, array_fill(0, $xmax + 1, ' '));
foreach ($coords as $coord) {
    [$x, $y] = explode(',', $coord);
    $map[(int)$y][(int)$x] = '#';
}

function foldHorizontaly(array &$map, int $y)
{
    $top = array_slice($map, 0, $y);
    $bottom = array_slice($map, $y + 1);
    $bottom = array_reverse($bottom);
    if (count($top) > count($bottom)) {
        array_unshift($bottom, array_fill(0, count($top[0]), ' '));
    }
    foreach ($top as $idx => $line) {
        foreach ($line as $x => $v) {
            $top[$idx][$x] = $v === '#' ? '#' : (isset($bottom[$idx][$x]) && $bottom[$idx][$x] === '#' ? '#' : ' ');
        }
    }

    $map = $top;
}

function foldVerticaly(mixed &$map, int $x)
{
    $result = [];
    foreach ($map as $line) {
        $left = array_slice($line, 0, $x);
        $right = array_slice($line, $x + 1);
        $right = array_reverse($right);
        foreach ($left as $idx => $value) {
            $left[$idx] = $value === '#' ? '#' : (isset($right[$idx]) && $right[$idx] === '#' ? '#' : ' ');
        }
        $result[] = $left;
    }

    $map = $result;
}
for ($i = 0, $iMax = count($folds); $i < $iMax; $i++) {
    $fold = $folds[$i];
    if ($fold['axe'] === 'y') {
        foldHorizontaly($map, $fold['value']);
        continue;
    }
    foldVerticaly($map, $fold['value']);
}
echo implode("\n", array_map(static fn($item) => implode('', $item), $map)) . "\n";
dump(substr_count(implode(array_map(static fn($item) => implode('', $item), $map)), '#'));
