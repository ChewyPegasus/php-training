<?php

declare(strict_types=1);

class Solution {

    /**
     * @param Integer[] $nums
     * @return Integer
     */
    function findMin($nums) {
        $n = count($nums);
        $left = 0;
        $right = $n - 1;

        while ($left < $right) {
            if ($nums[$left] < $nums[$right]) {
                return $nums[$left];
            }

            $mid = $left + intval(($right - $left) / 2);
            
            if ($nums[$mid] >= $nums[$left]) {
                $left = $mid + 1;
            } else {
                $right = $mid;
            }
        }
        return $nums[$left];
    }
}