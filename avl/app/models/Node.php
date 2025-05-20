<?php

declare(strict_types=1);

namespace App\Models;

class Node
{
    public function __construct(
        public int $key = 0, 
        public ?Node $left = null,
        public ?Node $right = null,
        public int $height = 1)
    {
    }

    public static function getHeight(?Node $node): int
    {
        if ($node === null) {
            return 0;
        }
        return $node->height;
    }

    public static function getBalanceFactor(?Node $node): int
    {
        if ($node === null) {
            return 0;
        }
        return (self::getHeight($node->left) - self::getHeight($node->right));
    }
}