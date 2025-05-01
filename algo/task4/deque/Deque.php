<?php

declare(strict_types=1);

class Deque {
    private const CHUNK_SIZE = 128;
    private array $data = [];
    private int $front_chunk_ptr = 0;
    private int $back_chunk_ptr = 0;
    private int $front_chunk_index = 0;
    private int $back_chunk_index = 0;
    private int $size = 0;

    public function __construct() {
        $this->data[0] = array_fill(0, self::CHUNK_SIZE, null);
        $this->front_chunk_index = $this->back_chunk_index = intval(self::CHUNK_SIZE / 2);
    }

    public function push_front($x): void {
        if ($this->empty()) {
            $this->data[$this->front_chunk_ptr][$this->front_chunk_index] = $x;
        } else {
            --$this->front_chunk_index;

            // нужно создать новый чанк
            if ($this->front_chunk_index < 0) {
                --$this->front_chunk_ptr;

                if (!isset($this->data[$this->front_chunk_ptr])) {
                    $this->data[$this->front_chunk_ptr] = array_fill(0, self::CHUNK_SIZE, null);
                }
                $this->front_chunk_index = self::CHUNK_SIZE - 1;
            }

            $this->data[$this->front_chunk_ptr][$this->front_chunk_index] = $x;
        }
        ++$this->size;
    }

    public function pop_front(): void {
        if ($this->empty()) {
            throw new BadMethodCallException("Deque is empty");
        }

        $this->data[$this->front_chunk_ptr][$this->front_chunk_index] = null;

        if ($this->size == 1) {
            //это был последний элемент
            $this->front_chunk_ptr = $this->back_chunk_ptr;
            $this->front_chunk_index = $this->back_chunk_index;
        } else {
            ++$this->front_chunk_index;

            if ($this->front_chunk_index >= self::CHUNK_SIZE) {
                ++$this->front_chunk_ptr;
                $this->front_chunk_index = 0;
            }
        }

        --$this->size;
    }

    public function push_back($x): void {
        if ($this->empty()) {
            $this->data[$this->back_chunk_ptr][$this->back_chunk_index] = $x;
        } else {
            ++$this->back_chunk_index;

            if ($this->back_chunk_index >= self::CHUNK_SIZE) {
                ++$this->back_chunk_ptr;

                if (!isset($this->data[$this->back_chunk_ptr])) {
                    $this->data[$this->back_chunk_ptr] = array_fill(0, self::CHUNK_SIZE, null);
                }

                $this->back_chunk_index = 0;
            }

            $this->data[$this->back_chunk_ptr][$this->back_chunk_index] = $x;
        }
        ++$this->size;
    }

    public function pop_back(): void {
        if ($this->empty()) {
            throw new BadMethodCallException("Deque is empty");
        }

        $this->data[$this->back_chunk_ptr][$this->back_chunk_index] = null;

        if ($this->size === 1) {
            $this->back_chunk_ptr = $this->front_chunk_ptr;
            $this->back_chunk_index = $this->front_chunk_index;
        } else {
            --$this->back_chunk_index;

            if ($this->back_chunk_index < 0) {
                --$this->back_chunk_ptr;
                $this->back_chunk_index = self::CHUNK_SIZE - 1;
            }
        }
        --$this->size;
    }

    public function front() {
        if ($this->empty()) {
            throw new BadMethodCallException("Deque is empty");
        }
        return $this->data[$this->front_chunk_ptr][$this->front_chunk_index];
    }

    public function back() {
        if ($this->empty()) {
            throw new BadMethodCallException("Deque is empty");
        }
        return $this->data[$this->back_chunk_ptr][$this->back_chunk_index];
    }

    public function empty(): bool {
        return ($this->size === 0);
    }

    public function size(): int {
        return ($this->size);
    }
}