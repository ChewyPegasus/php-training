<?php

declare(strict_types=1);

require "Node.php";
require "../AbstractQueue.php";

class DoubleConnectedQueue implements AbstractQueue
{
    private Node $dummy;
    private int $size = 0;

    public function __construct()
    {
        $this->dummy = new Node(null, null);
    }

    public function pushFront($x): void
    {
        if ($this->empty()) {
            $node = new Node($this->dummy, $this->dummy, $x);
            $this->dummy->next = $node;
            $this->dummy->prev = $node;
        } else {
            $node = $this->dummy->prev;
            $newNode = new Node($this->dummy, $node, $x);
            $node->next = $newNode;
            $this->dummy->prev = $newNode;
        }
        ++$this->size;
    }

    public function popFront(): void
    {
        if ($this->empty()) {
            throw new BadMethodCallException("DoubleConnectedQueue is empty");
        }
        if ($this->size === 1) {
            $node = $this->dummy->prev;
            unset($node);
            $this->dummy->prev = $this->dummy->next = null;
        } else {
            $newFront = $this->dummy->prev->prev;
            $node = $this->dummy->prev;
            unset($node);
            $newFront->next = $this->dummy;
            $this->dummy->prev = $newFront;
        }
        --$this->size;
    }

    public function pushBack($x): void
    {
        if ($this->empty()) {
            $node = new Node($this->dummy, $this->dummy, $x);
            $this->dummy->next = $node;
            $this->dummy->prev = $node;
        } else {
            $node = $this->dummy->next;
            $newNode = new Node($node, $this->dummy, $x);
            $node->prev = $newNode;
            $this->dummy->next = $newNode;
        }
        ++$this->size;
    }

    public function popBack(): void
    {
        if ($this->empty()) {
            throw new BadMethodCallException("DoubleConnectedQueue is empty");
        }
        if ($this->size === 1) {
            $node = $this->dummy->next;
            unset($node);
            $this->dummy->prev = $this->dummy->next = null;
        } else {
            $newBack = $this->dummy->next->next;
            $node = $this->dummy->next;
            unset($node);
            $this->dummy->next = $newBack;
            $newBack->prev = $this->dummy;
        }
        --$this->size;
    }

    public function back(): mixed
    {
        if ($this->empty()) {
            throw new BadMethodCallException("DoubleConnectedQueue is empty");
        }

        return ($this->dummy->next->val);
    }

    public function front(): mixed
    {
        if ($this->empty()) {
            throw new BadMethodCallException("DoubleConnectedQueue is empty");
        }

        return ($this->dummy->prev->val);
    }

    public function empty(): bool
    {
        return ($this->size === 0);
    }

    public function size(): int
    {
        return $this->size;
    }

    public function __print(): void
    {
        $cur = $this->dummy->prev;
        while ($cur !== $this->dummy) {
            echo $cur->val;
            $cur = $cur->prev;
        }
    }
}
