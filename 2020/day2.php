<?php

$input = file_get_contents('day2.txt');

$result = [];
preg_match_all('/(((\d+)\-(\d+)) (\w): (\w+))/m', $input, $result);

$data = [];
$data2 = [];
foreach ($result[3] as $key => $item) {
    $min = $result[3][$key];
    $max = $result[4][$key];
    $letter = $result[5][$key];
    $password = $result[6][$key];
    $count = substr_count($password, $letter);

    if ($count >= $min && $count <= $max) {
        $data[] = [$min, $max, $letter, $password, $count];
    }

    $letterOnMin = $password[$min - 1] ?? null;
    $letterOnMax = $password[$max - 1] ?? null;

    if (
        ($letterOnMin === $letter || $letterOnMax === $letter) &&
        ($letterOnMin !== $letterOnMax)
    ) {
        $data2[] = [$min, $max, $letter, $password];
    }

}
var_dump(count($data));
var_dump(count($data2));
