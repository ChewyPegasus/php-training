<?php

$host = 'localhost';
$port = '5432';
$dbname = 'php_postgres';
$user = 'postgres';
$password = 'postgres';

function getConnection() {
    global $host, $port, $dbname, $user, $password;
    
    try {
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
        $pdo = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        return $pdo;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage() . "\n");
    }
}