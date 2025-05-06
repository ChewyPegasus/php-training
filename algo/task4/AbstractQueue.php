<?php

declare(strict_types=1);

interface AbstractQueue {
    public function popFront(): void;
    public function popBack(): void;
    public function pushFront(mixed $x): void;
    public function pushBack(mixed $x): void;
    public function front(): mixed;
    public function back(): mixed;
    public function empty(): bool;
    public function size(): int;
}