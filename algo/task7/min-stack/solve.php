<?php
class MinStack {
    private array $stack = [];
    private array $minStack = [];

    public function __construct() {
    }

    public function push($val) {
        $this->stack[] = $val;
        
        if (empty($this->minStack) || $val <= end($this->minStack)) {
            $this->minStack[] = $val;
        }
    }

    public function pop() {
        $val = array_pop($this->stack);
        
        if (end($this->minStack) === $val) {
            array_pop($this->minStack);
        }
        
        return $val;
    }

    public function top() {
        return end($this->stack);
    }

    public function getMin() {
        return end($this->minStack);
    }
}