<?php

declare(strict_types=1);

require "../Sorting.php";

class Bubble extends Sorting {
    public function sort(array $arr, ?callable $comparator = null): array {
        $comparator = self::validateComparator($comparator);
        $n = count($arr);
        for ($i = 0; $i < $n - 1; ++$i) {
            for ($j = 0; $j < $n - $i - 1; ++$j) {
                if (!$comparator($arr[$j], $arr[$j + 1])) {
                    self::swap($arr[$j], $arr[$j + 1]);
                }
            }
        }
        return $arr;
    }
}