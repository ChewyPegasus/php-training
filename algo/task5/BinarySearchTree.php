<?php

declare(strict_types=1);

require "Node.php";

class BinarySearchTree
{
    private ?Node $root = null;

    public function __construct()
    {
    }

    public function search($x): bool
    {
        return ($this->execSearch($this->root, $x) !== null);
    }

    private function execSearch(?Node $cur, $x): ?Node
    {
        if ($cur === null || $cur->val === $x) {

            return $cur;
        }
        if ($x < $cur->val) {

            return $this->execSearch($cur->left, $x);
        }

        return $this->execSearch($cur->right, $x);
    }

    public function insert($x): void
    {
        $this->root = $this->execInsert($this->root, $x);
    }

    private function execInsert(?Node $cur, $x): ?Node
    {
        if ($cur === null) {

            return new Node(null, null, $x);
        }
        if ($x < $cur->val) {
            $cur->left = $this->execInsert($cur->left, $x);
        } elseif ($x > $cur->val) {
            $cur->right = $this->execInsert($cur->right, $x);
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
        $this->root = $this->execDelete($this->root, $x);
    }

    private function execDelete(?Node $cur, $x): ?Node
    {
        if ($cur === null) {

            return null;
        }
        if ($x > $cur->val) {
            $cur->right = $this->execDelete($cur->right, $x);
        } elseif ($x < $cur->val) {
            $cur->left = $this->execDelete($cur->left, $x);
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
                $cur->right = $this->execDelete($cur->right, $temp->val);
            }
        }

        return $cur;
    }

    public function postOrder(): void
    {
        $this->execPostOrder($this->root);
    }
    public function preOrder(): void
    {
        $this->execPreOrder($this->root);
    }
    public function inOrder(): void
    {
        $this->execInOrder($this->root);
    }

    private function execPostOrder(?Node $cur): void
    {
        if ($cur !== null) {
            $this->execPostOrder($cur->left);
            $this->execPostOrder($cur->right);
            echo $cur->val . " ";
        }
    }

    private function execInOrder(?Node $cur): void
    {
        if ($cur !== null) {
            $this->execInOrder($cur->left);
            echo $cur->val . " ";
            $this->execInOrder($cur->right);
        }
    }

    private function execPreOrder(?Node $cur): void
    {
        if ($cur !== null) {
            echo $cur->val . " ";
            $this->execPreOrder($cur->left);
            $this->execPreOrder($cur->right);
        }
    }
}
