<?php

declare(strict_types=1);

require_once __DIR__ . "/../app/bootstrap.php";

use App\Models\Article;
use App\Models\Comment;

$article = new Article();
$comment = new Comment();

$count = 10000;

$average = 0;
for ($i = 0; $i < $count; ++$i) {
    $start = microtime();
}