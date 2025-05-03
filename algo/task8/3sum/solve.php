<?php

declare(strict_types=1);

class Solution {

    function threeSum($nums) {
        sort($nums);

        $n = count($nums);
        $ans = [];
        for ($i = 0; $i < $n; ++$i) {
            if ($nums[$i] > 0) {
                break;
            }
            if ($i !== 0 && $nums[$i - 1] === $nums[$i]) continue;
            $l = $i + 1;
            $r = $n - 1;

            $sum = $nums[$i] + $nums[$l] + $nums[$r];

            while ($l < $r) {
                $sum = $nums[$i] + $nums[$l] + $nums[$r];

                if ($sum === 0) {
                    $ans[] = [$nums[$i], $nums[$l], $nums[$r]];

                    ++$l;
                    --$r;
                    while ($l < $r && $nums[$l - 1] === $nums[$l]) ++$l;
                    while ($l < $r && $nums[$r + 1] === $nums[$r]) --$r;
                } else if ($sum > 0) {
                    --$r;
                } else {
                    ++$l;
                }
            }
        }

        return $ans;
    }
}