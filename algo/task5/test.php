<?php

declare(strict_types=1);

require "BinarySearchTree.php";

$bst = new BinarySearchTree();

while (true) {
    $input = trim(readline());

    if ($input === 'order') {
        break;
    }

    $bst->insert((int)$input);
}

echo "\nInOrder traversal:\n";
$bst->inOrder();

echo "\nPreOrder traversal:\n";
$bst->preOrder();

echo "\nPostOrder traversal:\n";
$bst->postOrder();
