<?php
$fileContent = file('day7.txt');

$rules = [];
foreach ($fileContent as $line) {
    $line = trim($line);
    $lineArray = explode(' ', $line);
    $result = [];
    preg_match_all('/(\d+) (\w+ \w+) b/', $line, $result);
    $rules[$lineArray[0] . ' ' . $lineArray[1]] = [];
    foreach ($result[1] as $key => $number) {
        $rules[$lineArray[0] . ' ' . $lineArray[1]][] = ['number' => $number, 'bag' => $result[2][$key]];
    }
}

function findStep1(array $rules, string $searchedBag, array &$result)
{
    foreach ($rules as $bag => $rulesBag) {
        $bags = array_column($rulesBag, 'bag');
        if (in_array($searchedBag, $bags, true) && false === in_array($bag, $result, true)) {
            $result[] = $bag;
            findStep1($rules, $bag, $result);
        }
    }
}

function findStep2($rules, $searchedBag)
{
    $count = array_sum(array_column($rules[$searchedBag], 'number'));
    foreach ($rules[$searchedBag] as $rule) {
        $count += $rule['number'] * findStep2($rules, $rule['bag']);
    }

    return $count;
}

$result1 = [];
findStep1($rules, 'shiny gold', $result1);
var_dump(count($result1));
var_dump(findStep2($rules, 'shiny gold'));
