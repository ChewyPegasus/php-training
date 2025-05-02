<?php

declare(strict_types=1);

class Node
{
    public function __construct(public ?Node $next, public ?Node $prev, public $val = null)
    {
    }
}
