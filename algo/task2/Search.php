<?php

declare(strict_types=1);

abstract class Search {
    public abstract function search(array $arr, int $target): bool;
}