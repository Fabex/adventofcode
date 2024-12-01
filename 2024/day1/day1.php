<?php

function readFileLines($filename)
{
    return file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

$lines = readFileLines('data.txt');
$left = [];
$right = [];

foreach ($lines as $line) {
    $numbers = preg_split('/\s+/', trim($line));
    $left[] = (int)$numbers[0];
    $right[] = (int)$numbers[1];
}

sort($left);
sort($right);

$sum = 0;
$count = count($left);
for ($i = 0; $i < $count; $i++) {
    $sum += abs($left[$i] - $right[$i]);
}
echo "part 1 : $sum\n";

$sum = 0;
$rightCounts = array_count_values($right);
foreach ($left as $l) {
    $sum += ($rightCounts[$l] ?? 0) * $l;
}
echo "part 2 : $sum\n";
