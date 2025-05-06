<?php

declare(strict_types=1);

require "../Sorting.php";

class Quick extends Sorting {
    public function sort(array $arr, ?callable $comparator = null): array {
        $comparator = self::validateComparator($comparator);
        self::recursion($arr, 0, count($arr) - 1, $comparator);

        return $arr;
    }

    private function partition(array& $arr, int $left, int $right, ?callable $comparator = null): int
    {
        $comparator = self::validateComparator($comparator);

        $pivot = $arr[$right];
        $partitionIndex = $left - 1;
        for ($i = $left; $i < $right; ++$i) {
            if ($comparator($arr[$i], $pivot)) {
                self::swap($arr[++$partitionIndex], $arr[$i]);
            }
        }
        self::swap($arr[++$partitionIndex], $arr[$right]);

        return $partitionIndex;
    }

    private function recursion(array& $arr, int $left, int $right, ?callable $comparator = null): void
    {
        if ($left < $right) {
            $pivot = self::partition($arr, $left, $right, $comparator);

            self::recursion($arr, $left, $pivot - 1, $comparator);
            self::recursion($arr, $pivot + 1, $right, $comparator);
        }
    }
}