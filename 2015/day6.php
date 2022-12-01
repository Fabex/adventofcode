<?php
require __DIR__.'/../vendor/autoload.php';

function toggle(bool &$value)
{
    $value = !$value;
}

function on(bool &$value)
{
    $value = true;
}

function off(bool &$value)
{
    $value = false;
}

function apply(&$grid, $action, $start, $end)
{
    [$startX, $startY] = explode(',', $start);
    [$endX, $endY] = explode(',', $end);
    for(; $startX<=$endX; $startX++) {
        for(; $startY<=$endY; $startY++) {
            $action($grid[$startX][$startY]);
        }
    }
}

$instructions = file(__DIR__ . '/day6.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$grid = array_fill(0, 1000, false);
array_walk($grid, static fn(&$row) => $row = array_fill(0, 1000, false));

foreach ($instructions as $instruction) {
    preg_match_all('/(\w+) (\d{1,3},\d{1,3}) \w+ (\d{1,3},\d{1,3})/', $instruction, $result);
    apply($grid, str_replace('turn ', '', $result[1][0]), $result[2][0], $result[3][0]);
}
$lit = 0;
foreach ($grid as $row) {
    foreach ($row as $a) {
        $a ? $lit++ : '';
    }
}
dump($lit);
//dump($grid);
