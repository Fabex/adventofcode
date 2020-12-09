<?php
require 'vendor/autoload.php';

$data = file('day9.txt', FILE_IGNORE_NEW_LINES);

function calcSum(array $data)
{
    $sums = [];
    foreach ($data as $datum) {
        $a = array_shift($data);
        foreach ($data as $item) {
            $sums[] = $a + $item;
        }
    }

    return array_merge($sums);
}

$the25 = array_slice($data, 0, 25);
$others = array_slice($data, 25);
$sums = calcSum($the25);

$step1 = 0;
for ($i = 25, $iMax = count($data); $i <= $iMax; $i++) {
    $number = (int)$data[$i];
    if (false === in_array($number, $sums)) {
        $step1 = $number;
        break;
    }
    $the25 = array_slice($data, $i - 25 + 1, 25);
    $others = array_slice($data, 25 + $i);
    $sums = calcSum($the25);
}

$data = array_filter($data, function ($item) use ($step1) {
    return $item < $step1;
});

$step2 = [];
for ($start = 0, $startMax = count($data); $start < $startMax; $start++) {
    for ($end = 1, $endMax = count($data); $end < $endMax; $end++) {
        $sum = array_sum($t = array_slice($data, $start, $end));
        if ($sum === $step1) {
            $step2 = $t;
            break 2;
        }
    }
}

dump($step1);
dump(min($step2) + max($step2));
