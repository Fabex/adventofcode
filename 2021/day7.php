<?php
require __DIR__ . '/../vendor/autoload.php';

$crabsPositions = explode(',', trim(file_get_contents('day7.txt')));

[$minPosition, $maxPosition] = [(int)min($crabsPositions), (int)max($crabsPositions)];
$fuelStep1 = PHP_INT_MAX;
$fuelStep2 = PHP_INT_MAX;

for ($i = $minPosition; $i <= $maxPosition; $i++) {
    $currentFuelStep1 = 0;
    $currentFuelStep2 = 0;
    foreach ($crabsPositions as $position) {
        $move = abs($position - $i);
        $currentFuelStep1 += $move;
        $currentFuelStep2 += ($move * ($move + 1)) / 2;
    }
    if ($currentFuelStep1 < $fuelStep1) {
        $fuelStep1 = $currentFuelStep1;
    }
    if ($currentFuelStep2 < $fuelStep2) {
        $fuelStep2 = $currentFuelStep2;
    }
}
dump($fuelStep1);
dump($fuelStep2);
