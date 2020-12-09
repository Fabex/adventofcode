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

$invalidNumber = 0;
for ($i = 25, $iMax = count($data); $i <= $iMax; $i++) {
    $number = (int) $data[$i];
    if (false === in_array($number, $sums)) {
        $invalidNumber = $number;
        break;
    }
    $the25 = array_slice($data, $i-25+1, 25);
    $others = array_slice($data, 25+$i);
    $sums = calcSum($the25);
}

$data = array_filter($data, function($item) use ($invalidNumber) {
    return $item < $invalidNumber;
});

$step2 = [];
for ($start = 0, $startMax = count($data); $start < $startMax; $start++) {
    for ($end = 1, $endMax = count($data); $end < $endMax; $end++) {
        $sum = array_sum($t = array_slice($data, $start, $end));
        if($sum === $invalidNumber) {
            $step2 = $t;
            break 2;
        }
    }
}

dump($invalidNumber);
dump(min($step2)+max($step2));
