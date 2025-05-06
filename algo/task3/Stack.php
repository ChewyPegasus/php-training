<?php

declare(strict_types=1);

require_once "Node.php";

class Stack
{
    private ?Node $top = null;

    public function push(mixed $x): void
    {
        if ($this->top === null) {
            $this->top = new Node($x, null);

            return;
        }
        $node = new Node($x, $this->top);
        $this->top = $node;
    }

    public function pop(): void
    {
        if ($this->top === null) {
            throw new BadMethodCallException('Stack is empty');
        }
        $node = $this->top->prev;
        unset($this->top);
        $this->top = $node;
    }

    public function empty(): bool
    {
        return ($this->top === null);
    }

    public function top()
    {
        if ($this->top === null) {
            throw new BadMethodCallException('Stack is empty');
        }
        
        return ($this->top->value);
    }

    public function __destruct()
    {
        while (!$this->empty()) {
            $this->pop();
        }
    }
}
