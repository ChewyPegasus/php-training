<?php

declare(strict_types=1);

require "Deque.php";

$deque = new Deque();

$line = "";
while (($line = trim(fgets(STDIN))) !== "size") {
    $parts = explode(' ', $line);
    $cmd = $parts[0];

    if (count($parts) > 1) {
        $x = (int)$parts[1];
    }

    switch ($cmd) {
        case "front":
            $deque->push_front($x);
            break;
        case "back":
            $deque->push_back($x);
            break;
    }
}
echo $deque->size();
