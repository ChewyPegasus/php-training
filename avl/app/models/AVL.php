<?php

declare(strict_types=1);

namespace App\Models;

require_once __DIR__ . "/Node.php";

class AVL implements Tree {
    public function __construct(private ?Node $root = null)
    {
    }

    private function rightRotate(Node $y): Node
    {
        $x = $y->left;
        $T2 = $x->right;

        $x->right = $y;
        $y->left = $T2;

        $y->height = max(Node::getHeight($y->left), Node::getHeight($y->right)) + 1;
        $x->height = max(Node::getHeight($x->left), Node::getHeight($x->right)) + 1;

        return $x;
    }

    private function leftRotate(Node $x): Node
    {
        $y = $x->right;
        $T2 = $y->left;

        $y->left = $x;
        $x->right = $T2;

        $x->height = max(Node::getHeight($x->left), Node::getHeight($x->right)) + 1;
        $y->height = max(Node::getHeight($y->left), Node::getHeight($y->right)) + 1;

        return $y;
    }

    public function insert(int $key): bool
    {
        if ($this->find($key)) {
            return false;
        }
        
        $this->root = $this->insertNode($key, $this->root);

        return true;
    }

    private function insertNode(int $key, ?Node $node = null): Node
    {
        if ($node === null) {
            return new Node($key);
        }

        if ($key < $node->key) {
            $node->left = $this->insertNode($key, $node->left);
        } elseif ($key > $node->key) {
            $node->right = $this->insertNode($key, $node->right);
        } else {
            return $node;
        }

        $node->height = max(Node::getHeight($node->left), Node::getHeight($node->right)) + 1;
        
        $balance = Node::getBalanceFactor($node);

        if ($balance > 1 && $key < $node->left->key) {
            return $this->rightRotate($node);
        }

        if ($balance < -1 && $key > $node->right->key) {
            return $this->leftRotate($node);
        }

        if ($balance > 1 && $key > $node->left->key) {
            $node->left = $this->leftRotate($node->left);
            return $this->rightRotate($node);
        }

        if ($balance < -1 && $key < $node->right->key) {
            $node->right = $this->rightRotate($node->right);
            return $this->leftRotate($node);
        }

        return $node;
    }

    public function find(int $x): bool
    {
        $current = $this->root;
        
        while ($current !== null) {
            if ($x === $current->key) {
                return true;
            }
            
            if ($x < $current->key) {
                $current = $current->left;
            } else {
                $current = $current->right;
            }
        }
        
        return false;
    }

    public function postOrder(): array
    {
        $arr = [];
        $this->execPostOrder($this->root, $arr);
        return $arr;
    }

    public function preOrder(): array
    {
        $arr = [];
        $this->execPreOrder($this->root, $arr);
        return $arr;
    }

    public function inOrder(): array
    {
        $arr = [];
        $this->execInOrder($this->root, $arr);
        return $arr;
    }

    private function execPostOrder(?Node $cur, array &$arr): void
    {
        if ($cur !== null) {
            $this->execPostOrder($cur->left, $arr);
            $this->execPostOrder($cur->right, $arr);
            $arr[] = $cur->key;
        }
    }

    private function execInOrder(?Node $cur, array &$arr): void
    {
        if ($cur !== null) {
            $this->execInOrder($cur->left, $arr);
            $arr[] = $cur->key;
            $this->execInOrder($cur->right, $arr);
        }
    }

    private function execPreOrder(?Node $cur, array &$arr): void
    {
        if ($cur !== null) {
            $arr[] = $cur->key;
            $this->execPreOrder($cur->left, $arr);
            $this->execPreOrder($cur->right, $arr);
        }
    }

    public function delete(int $x): bool
    {
        if (!$this->find($x)) {
            return false;
        }
        
        $this->root = $this->deleteNode($this->root, $x);
        return true;
    }

    private function deleteNode(?Node $node, int $x): ?Node
    {
        if ($node === null) {
            return null;
        }
        
        if ($x < $node->key) {
            $node->left = $this->deleteNode($node->left, $x);
        } elseif ($x > $node->key) {
            $node->right = $this->deleteNode($node->right, $x);
        } else {
            if ($node->left === null) {
                $temp = $node->right;
                unset($node);
                return $temp;
            } elseif ($node->right === null) {
                $temp = $node->left;
                unset($node);
                return $temp;
            }

            $temp = $this->findMinValueNode($node->right);

            $node->key = $temp->key;
            
            $node->right = $this->deleteNode($node->right, $temp->key);
        }

        if ($node === null) {
            return null;
        }

        $node->height = max(Node::getHeight($node->left), Node::getHeight($node->right)) + 1;

        $balance = Node::getBalanceFactor($node);
        
        if ($balance > 1 && Node::getBalanceFactor($node->left) >= 0) {
            return $this->rightRotate($node);
        }

        if ($balance > 1 && Node::getBalanceFactor($node->left) < 0) {
            $node->left = $this->leftRotate($node->left);
            return $this->rightRotate($node);
        }
        
        if ($balance < -1 && Node::getBalanceFactor($node->right) <= 0) {
            return $this->leftRotate($node);
        }
        
        if ($balance < -1 && Node::getBalanceFactor($node->right) > 0) {
            $node->right = $this->rightRotate($node->right);
            return $this->leftRotate($node);
        }
        
        return $node;
    }

    private function findMinValueNode(Node $node): Node
    {
        $current = $node;

        while ($current->left !== null) {
            $current = $current->left;
        }
        
        return $current;
    }
}