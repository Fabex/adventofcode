<?php
require __DIR__ . '/../vendor/autoload.php';

$lines = file('day14.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

/** @var string $template */
$template = array_shift($lines);
$pairInsertion = [];
foreach ($lines as $line) {
    [$key, $value] = explode(' -> ', $line);
    $pairInsertion[$key] = $value;
}

$templateSplit = str_split($template);
$count = count($templateSplit);
$pairs = [];
for ($j = 0; $j < $count - 1; $j++) {
    $pair = $templateSplit[$j] . $templateSplit[$j + 1];
    if (!array_key_exists($pair, $pairs)) {
        $pairs[$pair] = 1;
        continue;
    }
    $pairs[$pair]++;
}

dump($pairs);
die('hard');
for ($i = 0; $i < 10; $i++) {
    $workPairs = $pairs;
    foreach ($pairs as $pair => $value) {
        if ($value === 0) {continue;}
        $t = $pairInsertion[$pair];
        $newPair1 = $pair[0] . $t;
        $newPair2 = $t.$pair[1];

        if (!array_key_exists($newPair1, $workPairs)) {
            $workPairs[$newPair1] = 1;
        } else {
            $workPairs[$newPair1]++;
        }
        if (!array_key_exists($newPair2, $workPairs)) {
            $workPairs[$newPair2] = 1;
        } else {
            $workPairs[$newPair2]++;
        }
        $workPairs[$pair]--;

    }
    $pairs = $workPairs;
}
dump($pairs);
$step2 = [];
foreach ($pairs as $pair => $value) {
    $letter1 = $pair[0];
    $letter2 = $pair[1];
    if (!array_key_exists($letter1, $step2)) {
        $step2[$letter1] = $value;
    } else {
        $step2[$letter1] += $value;
    }
    if (!array_key_exists($letter2, $step2)) {
        $step2[$letter2] = $value;
    } else {
        $step2[$letter2] += $value;
    }
}

dump($step2);
die('hard');
