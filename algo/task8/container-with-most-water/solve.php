<?php

declare(strict_types=1);

class Solution {

    /**
     * @param Integer[] $height
     * @return Integer
     */
    function maxArea($height) {
        $n = count($height);
        $left = 0;
        $right = $n - 1;

        $maxArea = PHP_INT_MIN;
        while ($left < $right) {
            $curArea = min($height[$left], $height[$right]) * ($right - $left);
            $maxArea = max($maxArea, $curArea);

            if ($height[$left] < $height[$right]) {
                ++$left;
            } else {
                --$right;
            }
        }

        return $maxArea;
    }
}