<?php

declare(strict_types=1);

require "Finder.php";

echo 'Количество тестов: ';
fscanf(STDIN, "%d\n", $tests);
echo 'Количество элементов в массиве: ';
fscanf(STDIN, "%d\n", $size);

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

    echo "Линейный поиск\n";
    echo "  Есть ли в массиве $target: ";
    $start = microtime(true);
    echo Finder::linear($arr, $target) ? 'Yes' : 'No';
    $time = microtime(true) - $start;
    echo "\n    Время работы: $time\n";

    echo "Двоичный поиск\n";
    echo "  Есть ли в массиве $target: ";
    $start = microtime(true);
    echo Finder::binary($arr, $target) ? 'Yes' : 'No';
    $time = microtime(true) - $start;
    echo "\n    Время работы: $time\n\n";
}
