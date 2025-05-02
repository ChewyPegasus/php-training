<?php

declare(strict_types=1);

class Solution {

    /**
     * @param String[][] $board
     * @return Boolean
     */
    public function isValidSudoku($board) {
        //validate boxes
        for ($i = 0; $i < 9; $i += 3) {
            for ($j = 0; $j < 9; $j += 3) {
                if (!$this->validateBox($board, $i, $j)) return false;
            }
        }
        //validate rows && cols
        for ($k = 0; $k < 9; ++$k) {
            if (!$this->validateRow($board, $k)) return false;
            if (!$this->validateCol($board, $k)) return false;
        }

        return true;
    }

    private function validateBox($board, $i_, $j_): bool {
        $collection = [];
        for ($i = $i_; $i < $i_ + 3; ++$i) {
            for ($j = $j_; $j < $j_ + 3; ++$j) {
                if ($board[$i][$j] === ".") continue;
                if (isset($collection[$board[$i][$j]])) return false;
                $collection[$board[$i][$j]] = true;
            }
        }
        return true;
    }

    private function validateRow($board, $i_) {
        $collection = [];
        for ($j = 0; $j < 9; ++$j) {
            if ($board[$i_][$j] === ".") continue;
            if (isset($collection[$board[$i_][$j]])) return false;
            $collection[$board[$i_][$j]] = true;
        }
        return true;
    }

    private function validateCol($board, $j_) {
        $collection = [];
        for ($i = 0; $i < 9; ++$i) {
            if ($board[$i][$j_] === ".") continue;
            if (isset($collection[$board[$i][$j_]])) return false;
            $collection[$board[$i][$j_]] = true;
        }
        return true;
    }
}