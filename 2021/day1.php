<?php
$rows = file('day1.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

function step1(array $rows): int
{
    $start = (int)array_shift($rows);
    $inc = 0;
    foreach ($rows as $row) {
        if ((int)$row > $start) {
            $inc++;
        }
        $start = $row;
    }

    return $inc;
}

function step2(array $rows): int
{
    $tmp = [];
    foreach ($rows as $i => $iValue) {
        if (!isset($rows[$i + 1], $rows[$i + 2])) {
            break;
        }
        $tmp[] = $iValue + $rows[$i + 1] + $rows[$i + 2];
    }

    return step1($tmp);
}

var_dump(step1($rows));
var_dump(step2($rows));
