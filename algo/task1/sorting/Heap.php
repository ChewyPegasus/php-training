<?php

declare(strict_types=1);

require "../Heap.php";
use DataStructure\Heap as HeapDS;

class Heap extends Sorting {
    public function sort(array $arr, ?callable $comparator = null): array {
        $comparator = self::validateComparator($comparator);
        $heap = new HeapDS();
        for ($i = 0; $i < count($arr); ++$i) {
            $heap->push($arr[$i]);
        }
        $arr = [];
        while (!$heap->empty()) {
            $arr[] = $heap->top();
            $heap->pop();
        }

        return $arr;
    }
}