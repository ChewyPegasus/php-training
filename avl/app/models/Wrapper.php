<?php

declare(strict_types=1);

namespace App\Models;

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Database\RedisConnection;
use App\Models\AVL;
use Redis;

class Wrapper implements Tree
{
    private Redis $redis;
    private AVL $tree;

    public function __construct(
        private int $cacheTTL = 10
    )
    {
        $this->redis = RedisConnection::getInstance();
        $this->tree = new AVL();
    }

    public function find(int $x): bool
    {
        $cacheKey = 'find:' . $x;
        $cached = $this->redis->get($cacheKey);

        if ($cached !== false) {
            return $cached === 'true';
        }

        $result = $this->tree->find($x);

        $this->redis->setex($cacheKey, $this->cacheTTL, $result ? 'true' : 'false');

        return $result;
    }

    public function postOrder(): array
    {
        $cacheKey = 'postOrder';
        $cached = $this->redis->get($cacheKey);

        if ($cached !== false) {
            return json_decode($cached, true);
        }

        $result = $this->tree->postOrder();

        $this->redis->setex($cacheKey, $this->cacheTTL, json_encode($result));

        return $result;
    }

    public function inOrder(): array
    {
        $cacheKey = 'inOrder';
        $cached = $this->redis->get($cacheKey);

        if ($cached !== false) {
            return json_decode($cached, true);
        }

        $result = $this->tree->inOrder();

        $this->redis->setex($cacheKey, $this->cacheTTL, json_encode($result));

        return $result;
    }

    public function preOrder(): array
    {
        $cacheKey = 'preOrder';
        $cached = $this->redis->get($cacheKey);

        if ($cached !== false) {
            return json_decode($cached, true);
        }

        $result = $this->tree->preOrder();

        $this->redis->setex($cacheKey, $this->cacheTTL, json_encode($result));

        return $result;
    }

    public function insert(int $x): bool
    {
        $success = $this->tree->insert($x);

        if ($success) {
            $this->redis->multi();
            $this->redis->del('inOrder', 'preOrder', 'postOrder');
            $this->redis->setex('find:' . $x, $this->cacheTTL, 'true');
            $this->redis->exec();
        }

        return $success;
    }

    public function delete(int $x): bool
    {
        $success = $this->tree->delete($x);

        if ($success) {
            $this->redis->del('preOrder', 'inOrder', 'postOrder');
            $this->redis->del('find:' . $x);
        }

        return $success;
    }
}