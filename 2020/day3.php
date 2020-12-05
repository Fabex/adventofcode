<?php

$groundLines = file('day3.txt');
$groundGrid = [];
foreach ($groundLines as $line) {
    $a = str_split($line);
    array_pop($a);
    $groundGrid[] = $a;
}

function move(array $line, int $start, int &$tree, int $right): int
{
    $position = $start + $right;
    $t = $line[$position] ?? null;
    if ($t === null) {
        throw new \Exception('', $position - count($line) - $right);
    }
    if ($t === '#') {
        $tree++;
        $line[$position] = 'X';
        echo implode('',$line)."\n";
    } else {
        $line[$position] = 'O';
        echo implode('',$line)."\n";
    }

    return $position;
}

function main(array $groundGrid, int $start, int &$tree, int $right, int $down = 1)
{
    foreach ($groundGrid as $i => $line) {
        if ($i === 0 || $i % $down) {
            echo implode('',$line)."\n";
            continue;
        }
        try {
            $end = move($line, $start, $tree, $right);
        } catch (\Exception $exception) {
            $start = $exception->getCode();
            if ($start === 0) {
                continue;
            }
            $end = move($line, $start, $tree, $right);
        }
        $start = $end;
    }
}
$tree = 0;
main($groundGrid, 0, $tree, 1);
$a1 = $tree;

$tree = 0;
main($groundGrid, 0, $tree, 3);
$a2 = $tree;

$tree = 0;
main($groundGrid, 0, $tree, 5);
$a3 = $tree;

$tree = 0;
main($groundGrid, 0, $tree, 7);
$a4 = $tree;

$tree = 0;
main($groundGrid, 0, $tree, 1, 2);
$a5 = $tree;

var_dump($a1,$a2,$a3,$a4,$a5);
var_dump($a1*$a2*$a3*$a4*$a5);
