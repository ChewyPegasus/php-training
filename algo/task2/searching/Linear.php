<?php

declare(strict_types=1);

require "../Search.php";

class Linear extends Search {
    public function search(array $arr, int $target): bool {
        foreach ($arr as $e) {
            if ($e === $target) {
                
                return true;
            }
        }

        return false;
    }
}