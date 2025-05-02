<?php

declare(strict_types=1);

class Solution {

    /**
     * @param String[] $strs
     * @return String[][]
     */
    function groupAnagrams($strs) {
        $rez = [];
        foreach ($strs as $str) {
            $strParts = str_split($str);
            sort($strParts);
            $rez[implode($strParts)][] = $str;
        }
        return $rez;
    }
}