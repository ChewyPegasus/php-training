<?php

declare(strict_types=1);

class Heap
{
    private $heap = [];

    private static function parentIndex(int $index): int
    {
        return (int)(($index - 1) / 2);
    }
    private static function rightIndex(int $index): int
    {
        return (int)(2 * $index + 2);
    }
    private static function leftIndex(int $index): int
    {
        return (int)(2 * $index + 1);
    }

    private function hasLeftChild(int $index): bool
    {
        return (self::leftIndex($index) < count($this->heap));
    }
    private function hasRightChild(int $index): bool
    {
        return (self::rightIndex($index) < count($this->heap));
    }
    private function hasChildren(int $index): bool
    {
        return $this->hasLeftChild($index);
    }

    private function smallestChildIndex($index): int
    {
        if ($this->hasRightChild($index)) {
            $l = self::leftIndex($index);
            $r = self::rightIndex($index);

            return $this->heap[$l] < $this->heap[$r] ? $l : $r;
        } else {
            return $this->leftIndex($index);
        }
    }

    private static function swap(&$x, &$y)
    {
        $temp = $x;
        $x = $y;
        $y = $temp;
    }

    public function push(int $c): void
    {
        $this->heap[] = $c;

        for ($i = count($this->heap) - 1; $i > 0;) {
            $pi = self::parentIndex($i);
            if ($this->heap[$i] < $this->heap[$pi]) {
                self::swap($this->heap[$i], $this->heap[$pi]);
                $i = $pi;
            } else {
                break;
            }
        }
    }

    public function pop(): void
    {
        if ($this->empty()) {
            return;
        }

        $lastIdx = count($this->heap) - 1;
        self::swap($this->heap[0], $this->heap[$lastIdx]);
        array_pop($this->heap);

        $i = 0;
        while ($this->hasChildren($i)) {
            $sci = $this->smallestChildIndex($i);
            if ($this->heap[$i] > $this->heap[$sci]) {
                self::swap($this->heap[$i], $this->heap[$sci]);
                $i = $sci;
            } else {
                break;
            }
        }
    }

    public function top(): int
    {
        if ($this->empty()) {
            throw new RuntimeException("Heap is empty");
        }
        return $this->heap[0];
    }

    public function empty(): bool
    {
        return empty($this->heap);
    }
}
