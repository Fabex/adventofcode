<?php
$secretKey = 'iwrupvqb';
for ($i = 0; $i < PHP_INT_MAX; $i++) {
    $md5 = md5($secretKey . $i);
    if (str_starts_with($md5, '00000')) {
        var_dump($i);
        break;
    }
}
for ($i = 0; $i < PHP_INT_MAX; $i++) {
    $md5 = md5($secretKey . $i);
    if (str_starts_with($md5, '000000')) {
        var_dump($i);
        break;
    }
}
