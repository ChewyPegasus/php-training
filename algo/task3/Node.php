<?php

declare(strict_types=1);

class Node
{
    public $value = null;
    public $prev = null;

    public function __construct($value, ?Node $prev)
    {
        $this->prev = $prev;
        $this->value = $value;
    }
}
