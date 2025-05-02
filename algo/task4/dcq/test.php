<?php

declare(strict_types=1);

require "DCQ.php";

$dcq = new DCQ();

$line = "";
while (($line = trim(fgets(STDIN))) !== "size") {
    $parts = explode(' ', $line);
    $cmd = $parts[0];
    
    if (count($parts) > 1) {
        $x = (int)$parts[1];
    }
    
    switch ($cmd) {
        case "front":
            $dcq->push_front($x);
            break;
        case "back":
            $dcq->push_back($x);
            break;
    }
}
echo $dcq->size() . "\n";

$dcq->__print();