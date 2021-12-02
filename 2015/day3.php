<?php

$data = file_get_contents('day3.txt');
$moves = str_split($data);
$map = ['0_0' => 1];
$x = 0;
$y = 0;
foreach ($moves as $i => $move) {
    switch ($move) {
        case '^': $y++; break;
        case 'v': $y--; break;
        case '<': $x--; break;
        case '>': $x++; break;
    }
    $coord = $x . '_' . $y;
    $map[$coord] = isset($map[$coord]) ? $map[$coord]+1 : 1;
}

var_dump(count($map));

$mapSanta = ['0_0' => 1];
$mapRobot = ['0_0' => 1];
$xSanta = 0;
$ySanta = 0;
$xRobot = 0;
$yRobot = 0;
foreach ($moves as $i => $move) {
    switch ($move) {
        case '^': $i % 2 ? $yRobot++ : $ySanta++ ; break;
        case 'v': $i % 2 ? $yRobot-- : $ySanta-- ; break;
        case '<': $i % 2 ? $xRobot-- : $xSanta-- ; break;
        case '>': $i % 2 ? $xRobot++ : $xSanta++ ; break;
    }
    $coordSanta = $xSanta . '_' . $ySanta;
    $mapSanta[$coordSanta] = isset($mapSanta[$coordSanta]) ? $mapSanta[$coordSanta]+1 : 1;
    $coordRobot = $xRobot . '_' . $yRobot;
    $mapRobot[$coordRobot] = isset($mapRobot[$coordRobot]) ? $mapRobot[$coordRobot]+1 : 1;
}

var_dump(count(array_merge($mapSanta,$mapRobot)));
