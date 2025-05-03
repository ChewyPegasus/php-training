<?php

declare(strict_types=1);

class Solution {

    /**
     * @param Integer[][] $matrix
     * @param Integer $target
     * @return Boolean
     */
    public function searchMatrix($matrix, $target) {
        $m = count($matrix);
        $n = count($matrix[0]);

        $left = 0;
        $right = $m - 1;
        while ($left <= $right) {
            $mid = intval($left + ($right - $left) / 2);

            if ($matrix[$mid][0] <= $target && $target <= $matrix[$mid][$n - 1]) {
                $row = $mid;
                break;
            } else if ($matrix[$mid][0] > $target) {
                $right = $mid - 1;
            } else {
                $left = $mid + 1;
            }
        }
        
        if ($left > $right) {
            return false;
        }

        $left = 0;
        $right = $n - 1;
        while ($left <= $right) {
            $mid = intval($left + ($right - $left) / 2);
            $num = $matrix[$row][$mid];

            if ($num === $target) return true;

            if ($num < $target) {
                $left = $mid + 1;
            } else {
                $right = $mid - 1;
            }
        }
        return false;
    }
}