<?php

declare(strict_types=1);

require "../AbstractQueue.php";

class Deque implements AbstractQueue
{
    private const CHUNK_SIZE = 128;
    private array $data = [];
    private int $frontChunkPtr = 0;
    private int $backChunkPtr = 0;
    private int $frontChunkIndex = 0;
    private int $backChunkIndex = 0;
    private int $size = 0;

    public function __construct()
    {
        $this->data[0] = array_fill(0, self::CHUNK_SIZE, null);
        $this->frontChunkIndex = $this->backChunkIndex = intval(self::CHUNK_SIZE / 2);
    }

    public function pushFront(mixed $x): void
    {
        if ($this->empty()) {
            $this->data[$this->frontChunkPtr][$this->frontChunkIndex] = $x;
        } else {
            --$this->frontChunkIndex;

            // нужно создать новый чанк
            if ($this->frontChunkIndex < 0) {
                --$this->frontChunkPtr;

                if (!isset($this->data[$this->frontChunkPtr])) {
                    $this->data[$this->frontChunkPtr] = array_fill(0, self::CHUNK_SIZE, null);
                }
                $this->frontChunkIndex = self::CHUNK_SIZE - 1;
            }

            $this->data[$this->frontChunkPtr][$this->frontChunkIndex] = $x;
        }
        ++$this->size;
    }

    public function popFront(): void
    {
        if ($this->empty()) {
            throw new BadMethodCallException("Deque is empty");
        }

        $this->data[$this->frontChunkPtr][$this->frontChunkIndex] = null;

        if ($this->size == 1) {
            //это был последний элемент
            $this->frontChunkPtr = $this->backChunkPtr;
            $this->frontChunkIndex = $this->backChunkIndex;
        } else {
            ++$this->frontChunkIndex;

            if ($this->frontChunkIndex >= self::CHUNK_SIZE) {
                ++$this->frontChunkPtr;
                $this->frontChunkIndex = 0;
            }
        }

        --$this->size;
    }

    public function pushBack($x): void
    {
        if ($this->empty()) {
            $this->data[$this->backChunkPtr][$this->backChunkIndex] = $x;
        } else {
            ++$this->backChunkIndex;

            if ($this->backChunkIndex >= self::CHUNK_SIZE) {
                ++$this->backChunkPtr;

                if (!isset($this->data[$this->backChunkPtr])) {
                    $this->data[$this->backChunkPtr] = array_fill(0, self::CHUNK_SIZE, null);
                }

                $this->backChunkIndex = 0;
            }

            $this->data[$this->backChunkPtr][$this->backChunkIndex] = $x;
        }
        ++$this->size;
    }

    public function popBack(): void
    {
        if ($this->empty()) {
            throw new BadMethodCallException("Deque is empty");
        }

        $this->data[$this->backChunkPtr][$this->backChunkIndex] = null;

        if ($this->size === 1) {
            $this->backChunkPtr = $this->frontChunkPtr;
            $this->backChunkIndex = $this->frontChunkIndex;
        } else {
            --$this->backChunkIndex;

            if ($this->backChunkIndex < 0) {
                --$this->backChunkPtr;
                $this->backChunkIndex = self::CHUNK_SIZE - 1;
            }
        }
        --$this->size;
    }

    public function front(): mixed
    {
        if ($this->empty()) {
            throw new BadMethodCallException("Deque is empty");
        }

        return $this->data[$this->frontChunkPtr][$this->frontChunkIndex];
    }

    public function back(): mixed
    {
        if ($this->empty()) {
            throw new BadMethodCallException("Deque is empty");
        }

        return $this->data[$this->backChunkPtr][$this->backChunkIndex];
    }

    public function empty(): bool
    {
        return ($this->size === 0);
    }

    public function size(): int
    {
        return ($this->size);
    }
}
