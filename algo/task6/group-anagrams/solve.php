<?php

declare(strict_types=1);

class Solution
{
    /**
     * @param String[] $strs
     * @return String[][]
     */
    public function groupAnagrams($strs)
    {
        $hash = [];

        foreach($strs as $str) {
            $hash[json_encode(count_chars($str, 1))][] = $str;
        }

        return $hash;
    }
}
