<?php

declare(strict_types=1);

class Solution {
    public function minEatingSpeed($piles, $h) {
        $left = 1;
        $right = PHP_INT_MIN;

        foreach($piles as $cnt) {
            $right = max($right, $cnt);
        }

        while ($left < $right) {
            $mid = $left + intval(($right - $left) / 2);

            if ($this->manage($mid, $h, $piles)) {
                $right = $mid;
            } else {
                $left = $mid + 1;
            }
        }
        return $left;
    }

    private function manage(int $k, int $h, array $piles) {
        $hours = 0;
        foreach($piles as $cnt) {
            $hours += intval($cnt / $k) + ($cnt % $k == 0 ? 0 : 1);
        }
        return $hours <= $h;
    }
}