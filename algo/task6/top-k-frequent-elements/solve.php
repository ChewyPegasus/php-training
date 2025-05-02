<?php

declare(strict_types=1);

class Solution {

    /**
     * @param Integer[] $nums
     * @param Integer $k
     * @return Integer[]
     */
    function topKFrequent($nums, $k) {
        $freq = [];

        foreach($nums as $x) {
            if (!isset($freq[$x])) {
                $freq[$x] = 0;
            }
            ++$freq[$x];
        }

        $pairs = [];
        foreach($freq as $letter => $fr) {
            $pairs[] = [$letter, $fr];
        }

        usort($pairs, function($a, $b) {
            return ($b[1] <=> $a[1]);
        });

        $rez = [];
        for ($i = 0; $i < $k; ++$i) {
            $rez[] = $pairs[$i][0];
        }

        return $rez;
    }
}