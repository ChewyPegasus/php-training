<?php

declare(strict_types=1);

require "Node.php";

class BST
{
    private ?Node $root = null;

    public function __construct()
    {
    }

    public function search($x): bool
    {
        return ($this->search_($this->root, $x) !== null);
    }

    private function search_(?Node $cur, $x): ?Node
    {
        if ($cur === null || $cur->val === $x) {
            return $cur;
        }
        if ($x < $cur->val) {
            return $this->search_($cur->left, $x);
        }
        return $this->search_($cur->right, $x);
    }

    public function insert($x): void
    {
        $this->root = $this->insert_($this->root, $x);
    }

    private function insert_(?Node $cur, $x): ?Node
    {
        if ($cur === null) {
            return new Node(null, null, $x);
        }
        if ($x < $cur->val) {
            $cur->left = $this->insert_($cur->left, $x);
        } elseif ($x > $cur->val) {
            $cur->right = $this->insert_($cur->right, $x);
        }
        return $cur;
    }

    public function findMin(?Node $cur = null): ?Node
    {
        if ($cur === null) {
            $cur = $this->root;
        }
        if ($cur === null) {
            return $cur;
        }
        if ($cur->left !== null) {
            return $this->findMin($cur->left);
        }
        return $cur;
    }

    public function delete($x): void
    {
        $this->root = $this->delete_($this->root, $x);
    }

    private function delete_(?Node $cur, $x): ?Node
    {
        if ($cur === null) {
            return null;
        }
        if ($x > $cur->val) {
            $cur->right = $this->delete_($cur->right, $x);
        } elseif ($x < $cur->val) {
            $cur->left = $this->delete_($cur->left, $x);
        } else {
            // Случай 1: Лист (нет детей)
            if ($cur->right === null && $cur->left === null) {
                unset($cur);
                return null;
            }
            // Случай 2: Один ребенок
            elseif ($cur->right === null || $cur->left === null) {
                $temp = ($cur->left === null) ? $cur->right : $cur->left;
                unset($cur);
                return $temp;
            }
            // Случай 3: Два ребенка
            else {
                $temp = $this->findMin($cur->right);
                $cur->val = $temp->val;
                $cur->right = $this->delete_($cur->right, $temp->val);
            }
        }
        return $cur;
    }

    public function postOrder(): void
    {
        $this->postOrder_($this->root);
    }
    public function preOrder(): void
    {
        $this->preOrder_($this->root);
    }
    public function inOrder(): void
    {
        $this->inOrder_($this->root);
    }

    private function postOrder_(?Node $cur): void
    {
        if ($cur !== null) {
            $this->postOrder_($cur->left);
            $this->postOrder_($cur->right);
            echo $cur->val . " ";
        }
    }

    private function inOrder_(?Node $cur): void
    {
        if ($cur !== null) {
            $this->inOrder_($cur->left);
            echo $cur->val . " ";
            $this->inOrder_($cur->right);
        }
    }

    private function preOrder_(?Node $cur): void
    {
        if ($cur !== null) {
            echo $cur->val . " ";
            $this->preOrder_($cur->left);
            $this->preOrder_($cur->right);
        }
    }
}
