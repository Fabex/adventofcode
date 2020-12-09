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

for ($i = 25, $iMax = count($data); $i <= $iMax; $i++) {
    $number = (int) $data[$i];
    if (false === in_array($number, $sums)) {
        dump($number);
        break;
    }
    $the25 = array_slice($data, $i-25+1, 25);
    $others = array_slice($data, 25+$i);
    $sums = calcSum($the25);
}


die('hard');

//dump($the25);
//dump($others);

die('hard');
