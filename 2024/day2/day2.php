<?php
## Generate by copilot -> convert from go to php
function readFileLines($filename): bool|array
{
    return file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

function isReportSafe($report): bool
{
    for ($i = 0; $i < count($report) - 1; $i++) {
        $diff = $report[$i + 1] - $report[$i];
        if ($diff === 0 || $diff < -3 || $diff > 3) {
            return false;
        }
        if ($i > 0 && ($diff > 0) !== ($report[$i] > $report[$i - 1])) {
            return false;
        }
    }
    return true;
}

function findMistake($report): bool
{
    for ($i = 0, $iMax = count($report); $i < $iMax; $i++) {
        $dolly = $report;
        array_splice($dolly, $i, 1);
        if (isReportSafe($dolly)) {
            return true;
        }
    }
    return false;
}

$lines = readFileLines('data.txt');
$reports = [];

foreach ($lines as $line) {
    if ($line === "") {
        continue;
    }
    $reports[] = array_map('intval', explode(' ', $line));
}

$totalSafePart1 = 0;
$totalSafePart2 = 0;

foreach ($reports as $report) {
    if (count($report) === 0) {
        continue;
    }
    $safe = isReportSafe($report);
    if ($safe) {
        $totalSafePart1++;
    } else {
        if (findMistake($report)) {
            $totalSafePart2++;
        }
    }
}

echo "part 1 : $totalSafePart1\n";
echo "part 2 : " . ($totalSafePart1 + $totalSafePart2) . "\n";
