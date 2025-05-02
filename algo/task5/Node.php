<?php

declare(strict_types=1);

class Node
{
    public function __construct(public ?Node $left, public ?Node $right, public $val = null)
    {
    }
}
