<?php

declare(strict_types=1);

require "DoubleConnectedQueue.php";

$dcq = new DoubleConnectedQueue();

$line = "";
while (($line = trim(fgets(STDIN))) !== "size") {
    $parts = explode(' ', $line);
    $cmd = $parts[0];

    if (count($parts) > 1) {
        $x = (int)$parts[1];
    }

    switch ($cmd) {
        case "front":
            $dcq->pushFront($x);
            break;
        case "back":
            $dcq->pushBack($x);
            break;
    }
}
echo $dcq->size() . PHP_EOL;

$dcq->__print();
