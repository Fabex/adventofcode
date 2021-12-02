<?php
$data = file_get_contents('day1.txt');
$open = substr_count($data, '(');
$close = substr_count($data, ')');
var_dump($open-$close);

$split = str_split($data);
$count = 0;
foreach ($split as $i => $value) {
    if ($value === '(') {
        $count++;
    }
    if ($value === ')') {
        $count--;
    }
    if ($count === -1) {
        var_dump($i+1);
        break;
    }
}


