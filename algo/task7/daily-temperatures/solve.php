<?php

declare(strict_types=1);

class Solution
{
    /**
     * @param Integer[] $temperatures
     * @return Integer[]
     */
    public function dailyTemperatures($temperatures)
    {
        $n = count($temperatures);

        $nextGreater = array_fill(0, $n, 0);

        $stack = [];

        for ($i = $n - 1; $i >= 0; --$i) {
            while (!empty($stack) && $temperatures[end($stack)] <= $temperatures[$i]) {
                array_pop($stack);
            }

            if (!empty($stack)) {
                $nextGreater[$i] = end($stack) - $i;
            }

            $stack[] = $i;
        }

        return $nextGreater;
    }
}
