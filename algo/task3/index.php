<?php

declare(strict_types=1);

require "Stack.php";

$testData = [
    "Привет",
    "Hello, world!",
    "",
    "лёша на полке клопа нашёл"
];

foreach ($testData as $test) {
    $stack = new Stack();

    foreach (mb_str_split($test) as $char) {
        $stack->push($char);
    }
    while (!$stack->empty()) {
        echo $stack->top();
        $stack->pop();
    }
    echo PHP_EOL;
}
