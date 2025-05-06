<?php

declare(strict_types=1);

class Node
{
    public function __construct(public $value, public ?Node $prev)
    {
    }
}
