<?php
$boxes = file('day2.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$step1 = 0;
foreach ($boxes as $box) {
    [$l, $w, $h] = explode('x', $box);
    $area1 = 2 * $lw = $l * $w;
    $area2 = 2 * $wh = $w * $h;
    $area3 = 2 * $hl = $h * $l;
    $minArea = min([$lw, $wh, $hl]);
    $step1 += $area1 + $area2 + $area3 + $minArea;
}

$step2 = 0;
foreach ($boxes as $box) {
    $t = [$l, $w, $h] = explode('x', $box);
    unset($t[array_search(max($t), $t, true)]);
    $ribbon = array_reduce($t, static function ($carry, $item) {
        return $carry + $item + $item;
    });
    $bow = $l * $w * $h;
    $step2 += $ribbon + $bow;
}

var_dump($step1);
var_dump($step2);
