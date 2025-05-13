<?php

declare(strict_types=1);

use App\Database\RedisConnection;

require_once __DIR__ . "/AVL.php";
require_once __DIR__ . "/database/RedisConnection.php";

class Wrapper {
    private Redis $redis;

    public function __construct(
        private AVL $tree,
        private int $cacheTTL = 60)
    {
        $this->redis = RedisConnection::getInstance();
    }

    public function find(int $x): bool {
        $cacheKey = "find:$x";
        $cached = $this->redis->get($cacheKey);

        if ($cached !== false) {
            return json_decode($cached, true);
        }

        $result = $this->tree->find($x);

        $this->redis->setex($cacheKey, $this->cacheTTL, $result ? "true" : "false");

        return $result;
    }

    public function postOrder() {
        $cacheKey = "postOrder";
        $cached = $this->redis->get($cacheKey);

        if ($cached !== false) {
            return json_decode($cached, true);
        }

        $result = $this->tree->postOrder();

        $this->redis->setex($cacheKey, $this->cacheTTL, json_encode($result));

        return $result;
    }

    public function inOrder() {
        $cacheKey = "inOrder";
        $cached = $this->redis->get($cacheKey);

        if ($cached !== false) {
            return json_decode($cached, true);
        }

        $result = $this->tree->inOrder();

        $this->redis->setex($cacheKey, $this->cacheTTL, json_encode($result));

        return $result;
    }

    public function preOrder() {
        $cacheKey = "preOrder";
        $cached = $this->redis->get($cacheKey);

        if ($cached !== false) {
            return json_decode($cached, true);
        }

        $result = $this->tree->preOrder();

        $this->redis->setex($cacheKey, $this->cacheTTL, json_encode($result));

        return $result;
    }

    public function insert(int $x): bool {
        $success = $this->tree->insert($x);

        if ($success) {
            $this->redis->del("preOrder", "inOrder", "postOrder");
            $this->redis->setex("find:$x", $this->cacheTTL, "true");
        }

        return $success;
    }

    public function delete(int $x): bool {
        $success = $this->tree->delete($x);

        if ($success) {
            $this->redis->del("preOrder", "inOrder", "postOrder");
            $this->redis->del("find:$x");
        }

        return $success;
    }
}