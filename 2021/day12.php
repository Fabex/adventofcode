<?php
require __DIR__ . '/../vendor/autoload.php';

$lines = array_map(static fn($line) => explode('-', $line), file('day12.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));

$map = [];
foreach ($lines as $line) {
    [$point1, $point2] = $line;
    $map[$point1] = [
        'lower' => ctype_lower($point1),
        'connectTo' => isset($map[$point1]['connectTo']) ? array_merge($map[$point1]['connectTo'], [$point2]) : [$point2],
    ];
    $map[$point2] = [
        'lower' => ctype_lower($point2),
        'connectTo' => isset($map[$point2]['connectTo']) ? array_merge($map[$point2]['connectTo'], [$point1]) : [$point1],
    ];
}

$paths = [];


function findPath($map, $cave, $currentPath, &$paths): bool
{
    foreach ($map[$cave]['connectTo'] as $connectTo) {
        $key = array_search($currentPath, $paths, true);
        if ($key !== false) {
            if (str_contains($paths[$key], $connectTo)) {
                continue;
            }
            if ('end' === $cave) {
                return false;
            }
            $paths[$key] .= ' - ' . $connectTo;
        }
        if (!findPath($map, $connectTo, $paths[$key], $paths)) {
            return false;
        }
    }
    return true;
}

foreach ($map['start']['connectTo'] as $connectTo) {
    $paths[] = $tmp = "start - $connectTo";
    findPath($map, $connectTo, $tmp, $paths);
//    foreach ($map[$connectTo]['connectTo'] as $connectTo2) {
//        $key = array_search("start - $connectTo", $paths, true);
//        if ($key !== false) {
//            if (str_contains($paths[$key], $connectTo2)) {
//                continue;
//            }
//            $paths[$key] .= ' - ' . $connectTo2;
//            if ('end' === $connectTo2) {
//                break;
//            }
//        }
//        foreach ($map[$connectTo2]['connectTo'] as $connectTo3) {
//            $key = array_search("start - $connectTo - $connectTo2", $paths, true);
//            if ($key !== false) {
//                if (str_contains($paths[$key], $connectTo3)) {
//                    continue;
//                }
//                $paths[$key] .= ' - ' . $connectTo3;
//                if ('end' === $connectTo3) {
//                    break;
//                }
//            }
//            foreach ($map[$connectTo3]['connectTo'] as $connectTo4) {
//                $key = array_search("start - $connectTo - $connectTo2 - $connectTo3", $paths, true);
//                if ($key !== false) {
//                    if (str_contains($paths[$key], $connectTo4)) {
//                        continue;
//                    }
//                    $paths[$key] .= ' - ' . $connectTo4;
//                    if ('end' === $connectTo4) {
//                        break;
//                    }
//                }
//            }
//        }
//    }
}
dump($paths);
die('hard');

dump($map);
die('hard');
