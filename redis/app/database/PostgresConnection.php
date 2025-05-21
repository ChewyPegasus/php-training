<?php

declare(strict_types=1);

namespace App\Database;

use PDO;
use PDOException;

class PostgresConnection extends Connection
{
    protected static ?PDO $instance = null;
    
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            try {
                $host = getenv('POSTGRES_HOST');
                $db = getenv('POSTGRES_DB');
                $user = getenv('POSTGRES_USER');
                $password = getenv('POSTGRES_PASSWORD');

                self::$instance = new PDO(
                    sprintf('pgsql:host=%s;dbname=%s', $host, $db),
                    $user,
                    $password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            } catch (PDOException $e) {
                die('Database connection failed' . $e->getMessage());
            }
        }
        return self::$instance;
    }
}