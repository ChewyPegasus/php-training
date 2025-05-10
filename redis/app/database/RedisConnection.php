<?php

declare(strict_types=1);

namespace App\Database;

use Predis\Client;

class RedisConnection extends Connection {
    protected static ?Client $instance = null;

    public static function getInstance(): Client
    {
        if (self::$instance === null) {
            $host = getenv('REDIS_HOST');
            $port = getenv('REDIS_PORT');
            
            try {
                $client = new Client([
                    'scheme' => 'tcp',
                    'host' => $host,
                    'port' => (int)$port
                ]);

                $client->ping();
                self::$instance = $client;
            } catch (\Exception $e) {
                die("Redis connection failed: " . $e->getMessage());
            }
        }
        
        return self::$instance;
    }
}