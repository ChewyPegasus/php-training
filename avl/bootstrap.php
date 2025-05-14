<?php

declare(strict_types=1);

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/app/database/Connection.php";
require_once __DIR__ . "/app/database/RedisConnection.php";

$envFile = __DIR__ . "/docker/.env";
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

use App\Database\RedisConnection;

try {
    $redis = RedisConnection::getInstance();
} catch (Exception $e) {
    echo "Error connecting to db: " . $e->getMessage();
    exit(1);
}