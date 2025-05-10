<?php

declare(strict_types=1);

namespace App\Database;

abstract class Connection {
    protected static $instance = null;

    abstract public static function getInstance();
}