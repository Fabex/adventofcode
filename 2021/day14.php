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

for ($i = 0; $i < 10; $i++) {
    $templateSplit = str_split($template);
    $count = count($templateSplit);
    $new = '';
    for ($j = 0; $j < $count - 1; $j++) {
        $pair = $templateSplit[$j] . $templateSplit[$j + 1];
        if ($j === 0) {
            $new .= $templateSplit[$j] . $pairInsertion[$pair] . $templateSplit[$j + 1];
            continue;
        }
        $new .= $pairInsertion[$pair] . $templateSplit[$j + 1];
    }
    $template = $new;
}
$occ = [];
foreach (count_chars($template, 1) as $i => $val) {
    $occ[chr($i)] = $val;
}
asort($occ);
dump(array_pop($occ) - array_shift($occ));
