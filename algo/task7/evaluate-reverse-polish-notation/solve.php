<?php

declare(strict_types=1);

class Solution
{
    /**
     * @param String[] $tokens
     * @return Integer
     */
    public function evalRPN($tokens)
    {
        array_reverse($tokens);
        $ops = [];

        foreach ($tokens as $token) {
            if (is_numeric($token)) {
                $ops[] = intval($token);
            } else {
                $right = array_pop($ops);
                $left = array_pop($ops);
                $rez = 0;
                switch ($token) {
                    case "+":
                        $rez = $left + $right;
                        break;
                    case "-":
                        $rez = $left - $right;
                        break;
                    case "/":
                        $rez = intval($left / $right);
                        break;
                    case "*":
                        $rez = $left * $right;
                        break;
                }
                $ops[] = $rez;
            }
        }
        return array_pop($ops);
    }
}
