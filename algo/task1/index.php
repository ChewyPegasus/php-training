<?php

declare(strict_types=1);

require "Sorter.php";

echo 'Количество тестов: ';
fscanf(STDIN, "%d\n", $tests);
echo 'Количество элементов в массиве: ';
fscanf(STDIN, "%d\n", $size);

for ($k = 0; $k < $tests; ++$k) {
    $arr = [];
    for ($j = 0; $j < $size; ++$j) {
        $arr[] = rand(0, 100);
    }

    echo 'Сгенерированный массив: ';
    for ($i = 0; $i < $size; ++$i) {
        echo $arr[$i] . ' ';
    } 
    echo "\n";
    
    $arrBubble = $arr;
    $arrQuick = $arr;
    $arrHeap = $arr;

    $bubbleResult = Sorter::bubble($arrBubble, null);
    echo 'Результат работы пузырька: ';
    for ($i = 0; $i < $size; ++$i) {
        echo $bubbleResult[$i] . ' ';
    } 
    echo "\n";

    $quickResult = Sorter::quick($arrQuick, null);
    echo 'Результат работы быстрой: ';
    for ($i = 0; $i < $size; ++$i) {
        echo $quickResult[$i] . ' ';
    } 
    echo "\n";
    
    $heapResult = Sorter::heap($arrHeap, null);
    echo 'Результат работы кучи: ';
    for ($i = 0; $i < $size; ++$i) {
        echo $heapResult[$i] . ' ';
    } 
    echo "\n";
}