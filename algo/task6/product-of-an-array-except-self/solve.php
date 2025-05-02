<?php

declare(strict_types=1);

class Solution
{
    /**
     * @param Integer[] $nums
     * @return Integer[]
     */
    public function productExceptSelf($nums)
    {
        $rez = array();
        $n = count($nums);
        $prefix = 1;
        for ($i = 0; $i < $n; ++$i) {
            $rez[$i] = $prefix;
            $prefix *= (int)$nums[$i];
        }

        $mul = 1;

        for ($i = $n - 1; $i >= 0; --$i) {
            $rez[$i] *= $mul;
            $mul *= (int)$nums[$i];
        }

        return $rez;
    }
}
