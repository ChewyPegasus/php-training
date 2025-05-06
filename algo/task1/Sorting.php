<?php

declare(strict_types=1);

abstract class Sorting {
    public abstract function sort(array $arr, ?callable $comparator = null): array;

    protected static function validateComparator(callable|null $comparator): callable
    {
        if ($comparator === null) {
            return self::getDefaultComparator();
        }
        if (!is_callable($comparator)) {
            throw new InvalidArgumentException('Comparator must be a callable.');
        }
        return $comparator;
    }

    protected static function swap(&$x, &$y)
    {
        $temp = $x;
        $x = $y;
        $y = $temp;
    }

    protected static function getDefaultComparator()
    {
        return function ($a, $b) {
            return $a < $b;
        };
    }
}