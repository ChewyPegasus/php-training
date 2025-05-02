<?php

declare(strict_types=1);

require "BST.php";

$bst = new BST();

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
