<?php

declare(strict_types=1);

class Node {
    public function __construct(public $val, public ?Node $prev, public $min){}
}

class MinStack {
    private Node $top;
    /**
     */
    function __construct() {
        $this->top = new Node(null, null, PHP_INT_MAX);
    }
  
    /**
     * @param Integer $val
     * @return NULL
     */
    function push($val) {
        $node = new Node($val, $this->top, min($val, $this->top->min));
        $this->top = $node;
    }
  
    /**
     * @return NULL
     */
    function pop() {
        $node = $this->top;
        $this->top = $this->top->prev;
        unset($node);
    }
  
    /**
     * @return Integer
     */
    function top() {
        return $this->top->val;
    }
  
    /**
     * @return Integer
     */
    function getMin() {
        return $this->top->min;
    }
}