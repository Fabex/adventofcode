<?php
$fileContent = file_get_contents('day4.txt');

function my_is_int($value, $len)
{
    $results = [];
    preg_match('/\d{' . $len . '}/', $value, $results);

    return (bool)count($results);
}

$mandatoryFields = [
    'byr' => function ($value) {
        echo '### byr ###'.PHP_EOL;
        return my_is_int($value, 4) && $value >= 1920 && $value <= 2002;
    },
    'iyr' => function ($value) {
        return my_is_int($value, 4) && $value >= 2010 && $value <= 2020;
    },
    'eyr' => function ($value) {
        return my_is_int($value, 4) && $value >= 2020 && $value <= 2030;
    },
    'hgt' => function ($value) {
        if (strpos($value, 'cm') !== false) {
            $value = (int)$value;
            return $value >= 150 && $value <= 193;
        }
        if (strpos($value, 'in') !== false) {
            $value = (int)$value;
            return $value >= 59 && $value <= 76;
        }

        return false;
    },
    'hcl' => function ($value) {
        if (strpos($value, '#') === false) {
            return false;
        }
        $value = str_replace('#', '', $value);

        return strlen($value) === 6 && ctype_xdigit($value);
    },
    'ecl' => function ($value) {
        $allowed = ['amb', 'blu', 'brn', 'gry', 'grn', 'hzl', 'oth'];

        return in_array($value, $allowed, true);
    },
    'pid' => function ($value) {
        $result = [];
        preg_match('/^\d{9}$/', $value, $result);
        return (bool)count($result);
    },
];

$result = [];
preg_match_all('/([\w:# ]+\n)+/', $fileContent, $result);

$passports = [];

foreach ($result[0] as $data) {
    $t = str_replace("\n", ' ', $data);
    $t = array_filter(explode(' ', $t));
    $passport = [];
    foreach ($t as $item) {
        $a = explode(':', $item);
        $passport[$a[0]] = $a[1];
    }
    $passports[] = $passport;
}
$valid1 = 0;
$valid2 = 0;
foreach ($passports as $passport) {
    if (isset($passport['byr'], $passport['iyr'], $passport['eyr'], $passport['hgt'], $passport['hcl'], $passport['ecl'], $passport['pid'])) {
        $valid1++;
        $validRule = true;
        foreach ($mandatoryFields as $field => $rule) {
            $r = $rule(trim($passport[$field]));
            $validRule = $validRule && $r;
        }
        if ($validRule) {
            $valid2++;
        }
    }
}
var_dump($valid1);
var_dump($valid2);
