<?php
require __DIR__.'/../vendor/autoload.php';

ini_set('memory_limit', '4G');

$data = file('day10bis.txt', FILE_IGNORE_NEW_LINES);
array_walk($data, function (&$item) {
    $item = (int)$item;
});
sort($data);
$prev = 0;
$diff1 = 0;
$diff3 = 1;
foreach ($data as $key => $datum) {
    if ($datum - $prev === 1) {
        ++$diff1;
    }
    if ($datum - $prev === 3) {
        ++$diff3;
    }
    $prev = $datum;
}
dump($step1 = $diff1 * $diff3);
/************************************************/
$mine = max($data) + 3;
$first = 0;
//$data[] = $mine;
//array_unshift($data, $first);

//$tmp = [];
//foreach ($data as $key => $datum) {
//    $tmp[$key] = ['jolt' => $datum, 'variation' => false];
//    if (isset($data[$key + 3]) && $data[$key + 3] - $datum === 3) {
//        $tmp[$key]['variation'] = true;
//    }
//}

//$shortPath = [];
//$i = 0;
//do {
//    $shortPath[$i] = $tmp[$i]['jolt'];
//    if ($tmp[$i]['jolt'] >= $mine) {
//        break;
//    }
//    if ($tmp[$i]['variation']) {
//        $i += 3;
//        continue;
//    }
//    ++$i;
//} while(true);

function canBePlugged(int $a, int $b)
{
    $diff = abs($a - $b);

    return 1 <=$diff && $diff <=3;
}


$plop = 0;
function step2(&$data, $start, &$plop): array
{
//    dump($start);
    $r[$data[$start]] = [];
    for ($j = $start, $jMax = count($data); $j < $jMax-1; $j++) {
        if (canBePlugged($data[$start], $data[$j + 1])) {
            $r[$data[$j]] = [];
            if ($j+1 < $jMax-1) {
                ++$plop;
                $r[$data[$j]] = step2($data, $j + 1, $plop);
            } else {
                break;
            }
        }
        if ($data[$j + 1] - $data[$start] > 3) {
            break;
        }
    }
    return $r;
}
$step2 = step2($data, 0, $plop);
dump($step2);
dump($plop);
dump(count($step2, COUNT_RECURSIVE));
die('hard');

die('hard');
dump($tmp);
//dump($shortPath);
die('hard');

die('hard');
