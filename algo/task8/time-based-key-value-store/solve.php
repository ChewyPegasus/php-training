<?php

declare(strict_types=1);

class TimeMap
{
    private array $data = [];

    public function __construct()
    {
        // пустовато тут
    }

    public function set(string $key, string $value, int $timestamp): void
    {
        if (!isset($this->data[$key])) {
            $this->data[$key] = [];
        }
        $this->data[$key][$timestamp] = $value;
    }

    public function get(string $key, int $timestamp): string
    {
        if (!isset($this->data[$key])) {
            return "";
        }

        $timestamps = array_keys($this->data[$key]);

        $index = $this->binarySearch($timestamps, $timestamp);

        return $index >= 0 ? $this->data[$key][$timestamps[$index]] : "";
    }

    private function binarySearch(array $timestamps, int $target): int
    {
        $left = 0;
        $right = count($timestamps) - 1;
        $result = -1;

        while ($left <= $right) {
            $mid = $left + intdiv($right - $left, 2);

            if ($timestamps[$mid] <= $target) {
                $result = $mid;
                $left = $mid + 1;
            } else {
                $right = $mid - 1;
            }
        }

        return $result;
    }
}
