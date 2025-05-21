<?php

declare(strict_types=1);

namespace App\Seeds;

use PDO;
use Faker\Generator;
use Faker\Factory;
use App\Database\PostgresConnection;

abstract class Seeder 
{
    protected PDO $db;
    protected Generator $faker;

    public function __construct() 
    {
        $this->db = PostgresConnection::getInstance();
        $this->faker = Factory::create();
    }

    abstract public function run(): void;

    abstract protected function generate(int $x): array;

    public function truncate(string $table): void 
    {
        $this->db->exec("TRUNCATE TABLE $table CASCADE");
    }
}