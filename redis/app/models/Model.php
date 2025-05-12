<?php
// filepath: d:\prog\php\php-training\redis\app\models\Model.php
declare(strict_types=1);

namespace App\Models;

use App\Database\PostgresConnection;
use App\Database\RedisConnection;
use PDO;
use Redis;

abstract class Model {
    protected PDO $db;
    protected Redis $redis;
    protected int $cacheTtl = 60;

    public function __construct()
    {
        $this->db = PostgresConnection::getInstance();
        $this->redis = RedisConnection::getInstance();
    }

    abstract public function create(array $data): int;

    abstract public function find(int $id): ?array;

    abstract public function findCached(int $id): ?array;
}