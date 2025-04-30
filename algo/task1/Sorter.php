<?php

declare(strict_types=1);

require_once "Heap.php";

class Sorter {
    private static function validateComparator(callable|null $comparator): callable {
        if ($comparator === null) {
            return self::getDefaultComparator();
        }
        if (!is_callable($comparator)) {
            throw new InvalidArgumentException('Comparator must be a callable.');
        }
        return $comparator;
    }

    private static function swap(&$x, &$y) {
        $temp = $x;
        $x = $y;
        $y = $temp;
    }

    private static function getDefaultComparator() {
        return function($a, $b) {
            return $a < $b;
        };
    }

    public static function bubble(array $arr, callable|null $comparator): array {
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

    private static function partition(array& $arr, int $left, int $right, callable|null $comparator): int {
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

    public static function quick(array $arr, callable|null $comparator): array {
        $comparator = self::validateComparator($comparator);
        self::quick_($arr, 0, count($arr) - 1, $comparator);
        return $arr;
    }

    private static function quick_(array& $arr, int $left, int $right, callable|null $comparator): void {
        if ($left < $right) {
            $pivot = self::partition($arr, $left, $right, $comparator);

            self::quick_($arr, $left, $pivot - 1, $comparator);
            self::quick_($arr, $pivot + 1, $right, $comparator);
        }
    }

    public static function heap(array $arr, callable|null $comparator) {
        $comparator = self::validateComparator($comparator);
        $heap = new Heap();
        for ($i = 0; $i < count($arr); ++$i) {
            $heap->push($arr[$i]);
        }
        $arr = [];
        while (!$heap->empty()) {
            $arr[] = $heap->top();
            $heap->pop();
        }
        return $arr;
    }
}