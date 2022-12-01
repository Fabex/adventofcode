<?php
require __DIR__ . '/../vendor/autoload.php';

$height = ['abcdefg'];

$zero = ['abcefg'];
$six = ['abdefg'];
$nine = ['abcdfg'];

$two = ['acdeg'];
$three = ['acdfg'];
$five = ['abdfg'];

$four = ['bcdf'];
$seven = ['acf'];
$one = ['cf'];


$lines = file('day8.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$step1 = 0;
foreach ($lines as $line) {
    [, $part2] = explode(' | ', $line);
    $digits = explode(' ', $part2);
    foreach ($digits as $digit) {
        $len = strlen(trim($digit));
        if ($len === 2 || $len === 3 || $len === 4 || $len === 7) {
            $step1++;
        }
    }
}
dump($step1);


/**
 *  top
 * l    r
 * t    t
 *  mid
 * l    r
 * b    b
 *  bot
 */
foreach ($lines as $line) {
    [$part1, $part2] = explode(' | ', $line);
    $digitsPart1 = explode(' ', $part1);

    usort($digitsPart1, static fn($item1, $item2) => strlen($item1) <=> strlen($item2));

    $plop = [
        'top' => [],
        'lt' => [],
        'rt' => [],
        'mid' => [],
        'lb' => [],
        'rb' => [],
        'bot' => [],
    ];
    dump($digitsPart1);
    foreach ($digitsPart1 as $digit) {
        $value = null;
        $segments = str_split($digit);
        if (strlen($digit) === 2) { // 1
            $plop['rt'] = $segments;
            $plop['rb'] = $segments;
        }
        if (strlen($digit) === 3) { // 7
            $plop['rt'] = count($plop['rt']) !== 0 ? array_intersect($segments, $plop['rt']) : $segments;
            $plop['rb'] = count($plop['rb']) !== 0 ? array_intersect($segments, $plop['rb']) : $segments;
            $plop['top'] = count($plop['rt']) !== 0 ? array_diff($segments, $plop['rt']) : $segments;
        }
        if (strlen($digit) === 4) { // 4
            $plop['rt'] = count($plop['rt']) !== 0 ? array_intersect($segments, $plop['rt']) : $segments;
            $plop['rb'] = count($plop['rb']) !== 0 ? array_intersect($segments, $plop['rb']) : $segments;
            $tmp = array_diff($segments, $plop['rt']);
            $plop['lt'] = count($plop['lt']) === 0 ? $tmp : array_intersect($tmp, $plop['lt']);
            $plop['mid'] = count($plop['mid']) === 0 ? $tmp : array_intersect($tmp, $plop['mid']);
        }
        if (strlen($digit) === 5) { // 2 3 5
            $plop['rt'] = count($plop['rt']) !== 0 ? (count(array_intersect($segments, $plop['rt'])) !== 0 ? array_intersect($segments, $plop['rt']) : $plop['rt']) : $segments;
            $plop['rb'] = count($plop['rb']) !== 0 ? (count(array_intersect($segments, $plop['rb'])) !== 0 ? array_intersect($segments, $plop['rb']) : $plop['rb']) : $segments;
            $plop['lt'] = count($plop['lt']) !== 0 ? (count(array_intersect($segments, $plop['lt'])) !== 0 ? array_intersect($segments, $plop['lt']) : $plop['lt']) : $segments;
            if (count($plop['lt']) === 0) {
                $tmp = array_diff($segments,  $plop['rt'], $plop['rb'], $plop['mid'], $plop['top']);
                $plop['lt'] = $tmp;
            } else {
                $plop['lt'] = (count(array_intersect($segments, $plop['lt'])) !== 0 ? array_intersect($segments, $plop['lt']) : $plop['lt']);
            }
            if (count($plop['mid']) === 0) {
                $tmp = array_diff($segments, $plop['rt']);
                $plop['mid'] = count($plop['mid']) === 0 ? $tmp : array_intersect($tmp, $plop['mid']);
            } else {
                $plop['mid'] = count($plop['mid']) !== 0 ? (count(array_intersect($segments, $plop['mid'])) !== 0 ? array_intersect($segments, $plop['mid']) : $plop['mid']) : $segments;
            }
            $tmp = array_diff($segments, $plop['rt'], $plop['rb'], $plop['lt'], $plop['mid'], $plop['top']);
            $lb = count($lb) === 0 ? $tmp : array_intersect($tmp, $lb);
            $bot = count($bot) === 0 ? $tmp : array_intersect($tmp, $bot);
        }
//        if (strlen($digit) >= 5) { // 0 6 9
//            $plop['rt'] = count($plop['rt']) !== 0 ? (count(array_intersect($segments, $plop['rt'])) !== 0 ? array_intersect($segments, $plop['rt']) : $plop['rt']) : $segments;
//            $plop['rb'] = count($plop['rb']) !== 0 ? (count(array_intersect($segments, $plop['rb'])) !== 0 ? array_intersect($segments, $plop['rb']) : $plop['rb']) : $segments;
//            $plop['lt'] = count($plop['lt']) !== 0 ? (count(array_intersect($segments, $plop['lt'])) !== 0 ? array_intersect($segments, $plop['lt']) : $plop['lt']) : $segments;
//            $plop['mid'] = count($plop['mid']) !== 0 ? (count(array_intersect($segments, $plop['mid'])) !== 0 ? array_intersect($segments, $plop['mid']) : $plop['mid']) : $segments;
//            $plop['top'] = count($plop['top']) !== 0 ? (count(array_intersect($segments, $plop['top'])) !== 0 ? array_intersect($segments, $plop['top']) : $plop['top']) : $segments;
//            $tmp = array_diff($segments, $plop['rt'], $plop['rb'], $plop['lt'], $plop['mid'], $plop['top']);
//            $plop['lb'] = count($plop['lb']) !== 0 ? (count(array_intersect($tmp, $plop['lb'])) !== 0 ? array_intersect($tmp, $plop['lb']) : $plop['lb']) : $segments;
//            $plop['bot'] = count($plop['bot']) !== 0 ? (count(array_intersect($tmp, $plop['bot'])) !== 0 ? array_intersect($tmp, $plop['bot']) : $plop['bot']) : $segments;
//        }
        dump($digit);
        dump($plop);
    }


    $digitsPart2 = explode(' ', $part2);
    die('hard');
}

