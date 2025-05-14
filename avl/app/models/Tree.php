<?php

declare(strict_types=1);

namespace App\Models;

interface Tree {
    public function find(int $x): bool;

    public function postOrder(): array;

    public function preOrder(): array;

    public function inOrder(): array;

    public function insert(int $x): bool;

    public function delete(int $x): bool;
}