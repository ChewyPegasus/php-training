<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\Database\Connection;
use App\Database\RedisConnection;

Connection::getInstance();
RedisConnection::getInstance();

use App\Seeds\ArticleSeeder;
use App\Seeds\CommentSeeder;

function seedDatabase(): void {
    echo "Starting DB seeding..." . PHP_EOL;

    $articleSeeder = new ArticleSeeder();
    $articleSeeder->run();

    $commentSeeder = new CommentSeeder();
    $commentSeeder->run();

    echo "DB seeding completed";
}

seedDatabase();