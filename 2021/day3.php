<?php
require '../2020/vendor/autoload.php';
$lines = file('day3.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
array_walk($lines, static fn(&$line) => $line = str_split($line));

$gamma = '';
$epsilon = '';
foreach ($lines[0] as $i => $v) {
    $t = array_count_values(array_column($lines, $i));
    $gamma .= $t[0] > $t[1] ? '0' : '1';
    $epsilon .= $t[0] > $t[1] ? '1' : '0';
}
$step1 = bindec($gamma) * bindec($epsilon);
dump($step1);

$nbBits = count($lines[0]);
$ox = '';
$keep = file('day3.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
for ($i = 0; $i < $nbBits; $i++) {
    $a = array_column($lines, $i);
    $t = array_count_values($a);
    $keepOx = (int) $t[1] >= (int) $t[0] ? 1 : 0;
    $ox .= $keepOx;
    foreach ($keep as $x => $line) {
        if (!str_starts_with($line, $ox)) {
            unset($keep[$x]);
            $lines = array_map(static fn($line) => str_split($line), $keep);
        }
    }
    if (count($keep) === 1) {
        $ox = array_pop($keep);
        dump('ox', $ox);
        break;
    }
}

$lines = file('day3.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
array_walk($lines, static fn(&$line) => $line = str_split($line));
$nbBits = count($lines[0]);
$co2 = '';
$keep = file('day3.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
for ($i = 0; $i < $nbBits; $i++) {
    $a = array_column($lines, $i);
    $t = array_count_values($a);
    $keepCo2 = $t[1] >= $t[0] ? 0 : 1;
    $co2 .= $keepCo2;
    foreach ($keep as $x => $line) {
        if (!str_starts_with($line, $co2)) {
            unset($keep[$x]);
            $lines = array_map(static fn($line) => str_split($line), $keep);
        }
    }
    if (count($keep) === 1) {
        $co2 = array_pop($keep);
        dump($co2);
        break;
    }
}
$step2 = bindec($ox) * bindec($co2);
dump($step2);
