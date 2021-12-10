<?php
require __DIR__ . '/../vendor/autoload.php';

$lines = file('day10.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$opens = ['(', '[', '{', '<'];
$closes = [')', ']', '}', '>'];
$closeErrorPoint = [")" => 3, "]" => 57, "}" => 1197, ">" => 25137];
$autocompletePoint = [')'=> 1, ']'=> 2, '}'=> 3, '>'=> 4];

$result = [];
$step1Result = 0;

$corrupted = [];
$map = [];
foreach ($lines as $line) {
    $chars = str_split($line);
    $tmp = [];
    foreach ($chars as $char) {
        if (in_array($char, $opens, true)) {
            $tmp[] = $char;
            continue;
        }
        if (array_search($char, $closes, true) === array_search($tmp[count($tmp) - 1], $opens, true)) {
            array_pop($tmp);
            continue;
        }
        $corrupted[] = $line;
        $step1Result += $closeErrorPoint[$char];
        break;
    }
}

$incompletes = array_diff($lines, $corrupted);
$scores = [];
foreach ($incompletes as $line) {
    $chars = str_split($line);
    $tmp = [];
    $score = 0;
    foreach ($chars as $char) {
        if (in_array($char, $opens, true)) {
            $tmp[] = $char;
            continue;
        }
        if (array_search($char, $closes, true) === array_search($tmp[count($tmp) - 1], $opens, true)) {
            array_pop($tmp);
            continue;
        }
    }
    $reverse = str_split(str_replace($opens, $closes, implode(array_reverse($tmp))));
    foreach ($reverse as $t) {
        $score *= 5;
        $score += $autocompletePoint[$t];
    }
    $scores[] = $score;
}

sort($scores);

dump($step1Result);
dump($scores[(int)  floor(count($scores)/2)]);

