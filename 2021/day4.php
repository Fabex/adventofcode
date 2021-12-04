<?php
require __DIR__.'/../vendor/autoload.php';

$data = file('day4.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$numbers = explode(',', array_shift($data));
$grids = array_chunk($data, 5);

array_walk($grids, static fn(&$grid) =>
    array_walk($grid, static fn(&$row) =>
        $row = array_map(static fn($item) =>
            ['value' => (int) trim($item), 'state' => false],  str_split($row, 3)
        )
    )
);

$winGrid=[];
$win = false;
foreach ($numbers as $number) {
    foreach ($grids as $g => $grid) {
        if (array_key_exists($g, $winGrid)) {
            continue;
        }
        foreach ($grid as $r => $row) {
            foreach ($row as $c => $col) {
                if ($col['value'] === (int) $number) {
                    $grids[$g][$r][$c]['state'] = true;
                    if (!in_array(false, array_column($grids[$g][$r], 'state'), true)) {
                        $win = true;
                    }

                    $t = true;
                    foreach ($grids[$g] as $k => $v) {
                        $t &= $v[$c]['state'];
                    }
                    if ($t) {
                        $win = true;
                    }
                    if ($win) {
                        $winGrid[$g] = $number;
                        $win = false;
                        break 2;
                    }
                }
            }
        }
    }
}

$unmarkedTotal = 0;
foreach ($grids[array_key_first($winGrid)] as $k => $v) {
    foreach ($v as $kk => $vv) {
        if (!$vv['state']) {
            $unmarkedTotal += $vv['value'];
        }
    }
}

$step1 = $winGrid[array_key_first($winGrid)] * $unmarkedTotal;

$unmarkedTotal = 0;
foreach ($grids[array_key_last($winGrid)] as $k => $v) {
    foreach ($v as $kk => $vv) {
        if (!$vv['state']) {
            $unmarkedTotal += $vv['value'];
        }
    }
}

$step2 = array_pop($winGrid) * $unmarkedTotal;

dump($step1);
dump($step2);
