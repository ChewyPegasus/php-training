<?php
declare(strict_types=1);

namespace App\Database;

use Redis;
use Exception;

class RedisConnection extends Connection
{
    protected static ?Redis $instance = null;

    public static function getInstance(): Redis
    {
        if (self::$instance === null) {
            $host = getenv('REDIS_HOST') ?: 'redis';
            $port = getenv('REDIS_PORT') ?: 6379;
            
            try {
                $redis = new Redis();
                if (!$redis->connect($host, (int)$port)) {
                    throw new Exception("Could not connect to Redis server");
                }
                
                $redis->ping();
                self::$instance = $redis;
            } catch (Exception $e) {
                die("Redis connection failed: " . $e->getMessage());
            }
        }
        
        return self::$instance;
    }
}
