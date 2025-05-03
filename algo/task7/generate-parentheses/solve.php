<?php

declare(strict_types=1);

class Solution
{
    /**
     * @param Integer $n
     * @return String[]
     */
    public function generateParenthesis($n)
    {
        $dp = [];
        $dp[0][] = "";

        for ($i = 1; $i <= $n; ++$i) {
            for ($j = 0; $j < $i; ++$j) {
                $left = $dp[$j];
                $right = $dp[$i - $j - 1];

                foreach ($left as $l) {
                    foreach ($right as $r) {
                        $dp[$i][] = "(" . $l . ")" . $r;
                    }
                }
            }
        }
        return $dp[$n];
    }
}
