<?php

declare(strict_types=1);

class Solution
{
    public function topKFrequent($nums, $k)
    {
        $freq = array_count_values($nums);
        arsort($freq);

        return array_slice(array_keys($freq), 0, $k);
    }
}
