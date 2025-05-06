<?php

declare(strict_types=1);

require "../Search.php";

class Binary extends Search {
    public function search(array $arr, int $target): bool {
        sort($arr);
        $l = 0;
        $r = count($arr);
        while ($l < $r) {
            $m = (int)($l + ($r - $l) / 2);

            if ($target === $arr[$m]) {
                return true;
            }

            if ($target < $arr[$m]) {
                $r = $m;
            } else {
                $l = $m + 1;
            }
        }
        
        return $l < count($arr) && $arr[$l] === $target;
    }
}