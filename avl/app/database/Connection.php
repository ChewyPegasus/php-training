<?php

declare(strict_types=1);

namespace App\Database;

abstract class Connection
{
    abstract public static function getInstance();
}