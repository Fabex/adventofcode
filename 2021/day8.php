<?php
require __DIR__ . '/../vendor/autoload.php';

$lines = file('day8.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$step1 = 0;
foreach ($lines as $line) {
    [,$part2] = explode(' | ', $line);
    $digits = explode(' ', $part2);
    foreach ($digits as $digit) {
        $len = strlen(trim($digit));
        if ($len === 2 || $len === 3 || $len === 4 || $len === 7) {
            $step1++;
        }
    }
}
dump($step1);


