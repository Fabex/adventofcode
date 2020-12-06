<?php

$fileContent = file_get_contents('day6.txt');

$groupsAnswers = [];
preg_match_all('/(\w{1,26}\n)+/', $fileContent, $groupsAnswers);
$groupsAnswers = $groupsAnswers[0];
$yes1 = 0;
$yes2 = 0;
array_walk($groupsAnswers, function (string &$answer) use (&$yes1, &$yes2) {
    $answer = array_filter(explode("\n", $answer));
    array_walk($answer, function (string &$a) {
        $a = str_split($a);
    });
    $yes1 += count(array_unique(array_merge(...$answer)));
    $t = [...$answer];
    if (count($t) === 1) {
        $yes2 += count(...$t);

        return;
    }
    $yes2 += count(array_intersect(...$answer));
});
var_dump($yes1);
var_dump($yes2);
