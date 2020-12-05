<?php
$data = file('day1.txt');

$result = null;
$start = microtime(true);
foreach ($data as $i => $b) {
    foreach ($subdata = array_slice($data, $i + 1) as $y => $c) {
        foreach (array_slice($subdata, $y + 1) as $d) {
            if (((int) $b + (int) $c + (int) $d) === 2020) {
                $result = (int) $b * (int) $c * (int) $d;
                break(3);
            }
        }
    }
}
var_dump($result);
