<?php

declare(strict_types=1);

require "searching/Binary.php";
require "searching/Linear.php";

echo 'Количество тестов: ';
fscanf(STDIN, "%d\n", $tests);
echo 'Количество элементов в массиве: ';
fscanf(STDIN, "%d\n", $size);

$binary = new Binary();
$linear = new Linear();

for ($k = 0; $k < $tests; ++$k) {
    $arr = [];
    for ($j = 0; $j < $size; ++$j) {
        $arr[] = rand(0, 10000);
    }

    echo 'Сгенерированный массив: ';
    for ($i = 0; $i < $size; ++$i) {
        echo $arr[$i] . ' ';
    }
    echo "\n";

    $target = rand(100, 1000);

    echo "Линейный поиск" . PHP_EOL;
    echo "\t" . "Есть ли в массиве $target: ";
    $start = microtime(true);
    echo $linear->search($arr, $target) ? 'Yes' : 'No';
    $time = microtime(true) - $start;
    echo PHP_EOL . "\t" . "Время работы: $time" . PHP_EOL;

    echo "Двоичный поиск" . PHP_EOL;
    echo "\t" . "Есть ли в массиве $target: ";
    $start = microtime(true);
    echo $binary->search($arr, $target) ? 'Yes' : 'No';
    $time = microtime(true) - $start;
    echo PHP_EOL . "\t" . "Время работы: $time" . PHP_EOL;
}
