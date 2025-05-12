<?php

require_once __DIR__ . "/../vendor/autoload.php";

$envFile = __DIR__ . "/../docker/.env";
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '#') === 0) {
            continue;
        }
        list($name, $value) = explode('=', $line, 2);
        putenv("$name=$value");
    }
}

use App\Database\PostgresConnection;
use App\Database\RedisConnection;

try {
    $db = PostgresConnection::getInstance();
    $redis = RedisConnection::getInstance();
} catch (Exception $e) {
    echo "Error connecting to databases: " . $e->getMessage();
    exit(1);
}

use App\Seeds\ArticleSeeder;
use App\Seeds\CommentSeeder;

function seedDatabase(): void {
    echo "Starting DB seeding..." . "<br>";

    $articleSeeder = new ArticleSeeder();
    $articleSeeder->run();

    $commentSeeder = new CommentSeeder();
    $commentSeeder->run();

    echo "DB seeding completed";
}

seedDatabase();