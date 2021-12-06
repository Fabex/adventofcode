<?php
require __DIR__ . '/../vendor/autoload.php';

$fish = explode(',', trim(file_get_contents('day6.txt')));

$unique = [];
foreach ($fish as $life) {
    $unique[$life] = isset($unique[$life]) ? $unique[$life] + 1: 1;
}
$unique += array_fill_keys(range(0, 8), 0);

$day = 1;
$maxDay = 256;
do {
    [$zero, $one, $tow, $three, $four, $five, $six, $seven, $height] = $unique;

    $unique[0] = $one;
    $unique[1] = $tow;
    $unique[2] = $three;
    $unique[3] = $four;
    $unique[4] = $five;
    $unique[5] = $six;
    $unique[6] = $seven + $zero;
    $unique[7] = $height;
    $unique[8] = $zero;

    $day++;

} while ($day <= $maxDay);

dump(array_sum($unique));
