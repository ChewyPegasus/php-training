<?php

declare(strict_types=1);

class Solution
{
    /**
     * @param int[] $nums
     * @return int
     */
    public function longestConsecutive($nums)
    {
        $hash = [];
        foreach ($nums as $num) {
            $hash[$num] = true;
        }
        $maxLength = PHP_INT_MIN;
        foreach ($hash as $num => $_) {
            if (!isset($hash[$num - 1])) {
                $length = 1;
                while (isset($hash[$num + $length])) {
                    ++$length;
                }
                $maxLength = max($maxLength, $length);
            }
        }
        return $maxLength == PHP_INT_MIN ? 0 : $maxLength;
    }
}
