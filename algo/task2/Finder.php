<?php

declare(strict_types=1);

class Finder
{
    public static function linear(array $arr, int $target): bool
    {
        foreach ($arr as $e) {
            if ($e === $target) {
                return true;
            }
        }
        return false;
    }

    public static function binary(array $arr, int $target): bool
    {
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
