<?php

declare(strict_types=1);

class Solution {

    function carFleet($target, $position, $speed) {
        $cars = [];
        for ($i = 0; $i < count($position); ++$i) {
            $cars[$position[$i]] = $speed[$i];
        }
        krsort($cars);

        $biggestTime = PHP_INT_MIN;
        $carFleets = 0;
        
        foreach($cars as $position => $speed) {
            $timeToTarget = ($target - $position) / $speed;
            if ($timeToTarget > $biggestTime) {
                ++$carFleets;
                $biggestTime = $timeToTarget;
            }
        }
        return $carFleets;
    }
}