<?php

declare(strict_types=1);

require "sorting/Bubble.php";
require "sorting/Heap.php";
require "sorting/Quick.php";

echo 'Количество тестов: ';
fscanf(STDIN, "%d\n", $tests);
echo 'Количество элементов в массиве: ';
fscanf(STDIN, "%d\n", $size);

$bubble = new Bubble();
$heap = new Heap();
$quick = new Quick();

for ($k = 0; $k < $tests; ++$k) {
    $arr = [];
    for ($j = 0; $j < $size; ++$j) {
        $arr[] = rand(0, 100);
    }

    echo 'Сгенерированный массив: ';
    for ($i = 0; $i < $size; ++$i) {
        echo $arr[$i] . ' ';
    }
    echo PHP_EOL;

    $arrBubble = $arr;
    $arrQuick = $arr;
    $arrHeap = $arr;

    $bubbleResult = $bubble->sort($arrBubble);
    echo 'Результат работы пузырька: ';
    for ($i = 0; $i < $size; ++$i) {
        echo $bubbleResult[$i] . ' ';
    }
    echo PHP_EOL;

    $quickResult = $quick->sort($arrQuick);
    echo 'Результат работы быстрой: ';
    for ($i = 0; $i < $size; ++$i) {
        echo $quickResult[$i] . ' ';
    }
    echo PHP_EOL;

    $heapResult = $heap->sort($arrHeap);
    echo 'Результат работы кучи: ';
    for ($i = 0; $i < $size; ++$i) {
        echo $heapResult[$i] . ' ';
    }
    echo PHP_EOL;
}
