<?php
require '../2020/vendor/autoload.php';

$strings = file('day5.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$step1 = 0;
foreach ($strings as $string) {
    preg_match_all('/[aeiou]/i', $string, $result);
    if (count($result[0]) >= 3) {
        preg_match_all('/aa|bb|cc|dd|ee|ff|gg|hh|ii|jj|kk|ll|mm|nn|oo|pp|qq|rr|ss|tt|uu|vv|ww|xx|yy|zz/i', $string, $result);
        if (count($result[0]) > 0) {
            preg_match_all('/ab|cd|pq|xy/i', $string, $result);
            if (count($result[0]) === 0) {
                $step1++;
            }
        }
    }
}
dump($step1);


$step2 = 0;
foreach ($strings as $string) {
    $chunk = str_split($string);
    foreach ($chunk as $i => $v) {
        if (!isset($chunk[$i+1])) {break;}
        $g = $v.$chunk[$i+1];
        if (str_contains(substr($string, $i+2), $g)) {
            foreach ($chunk as $ii => $vv) {
                if (isset($chunk[$ii + 2]) && $vv === $chunk[$ii + 2]) {
                    $step2++;
                    break 2;
                }
            }
        }
    }
}
dump($step2);
