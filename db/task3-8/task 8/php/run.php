<?php

require __DIR__ . '/../php/config.php';

$query = file_get_contents($argv[1]);
$pdo = getConnection();
//echo 'Connected succesfully';

$startTime = microtime(true);
$pdo->exec($query);
$time = microtime(true) - $startTime;
echo "Query executed in $time seconds\n";