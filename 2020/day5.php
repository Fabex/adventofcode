<?php

function getSeatId(int $row, int $column)
{
    return ($row * 8) + $column;
}

function get(array $specs, int $min, int $max)
{
    foreach ($specs as $spec) {
        [$min, $max] = getHalf($spec, $min, $max);
    }

    return $min;
}

function getHalf(string $spec, int $min, int $max)
{
    if ( in_array($spec, ['F', 'L'])) {
        return [$min, floor($max - ($max - $min) / 2)];
    }
    if ( in_array($spec, ['B', 'R'])) {
        return [ceil($min + ($max - $min) / 2), $max];
    }
    throw new \Exception('bad half');
}

$lines = file('day5.txt');

$result = [];
foreach ($lines as $line) {
    $t = str_split(trim($line));
    $rowSpecs = array_slice($t, 0, 7);
    $columnSpecs = array_slice($t, 7, 10);
    $row = get($rowSpecs, 0, 127);
    $column = get($columnSpecs, 0, 7);
    $result[] = getSeatId($row, $column);
}
sort($result);

$mySeat = null;
foreach ($result as $seatId) {
    $next = next($result);
    if ($seatId + 1 !== $next) {
        $mySeat = $seatId +1;
        break;
    }
}

var_dump(max($result));
var_dump($mySeat);
