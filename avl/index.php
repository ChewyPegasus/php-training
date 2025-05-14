<?php
declare(strict_types=1);

require_once __DIR__ . "/bootstrap.php";
require_once __DIR__ . "/app/controllers/BenchmarkController.php";

$controller = new BenchmarkController();
$controller->runBenchmark(10000);