<?php
// filepath: d:\prog\php\php-training\redis\app\models\Article.php
namespace App\Models;

use App\Database\PostgresConnection;
use PDO;
use Redis;

class Article extends Model {
    protected int $cacheTtl = 3600;

    public function create(array $data): int {
        $query = "INSERT INTO articles (title, content)
                    VALUES (:title, :content) RETURNING id";
        $stmt = $this->db->prepare($query);

        $stmt->execute($data);

        $id = (int) $stmt->fetchColumn(0);

        // Изменена работа с Redis
        $this->redis->del('articles:all');

        return $id;
    }

    public function all(): array {
        // Изменена работа с Redis
        $cached = $this->redis->get('articles:all');

        if ($cached) {
            return json_decode($cached, true);
        }

        $stmt = $this->db->query("SELECT * FROM articles ORDER BY created_at DESC");
        $articles = $stmt->fetchAll();

        // Изменена работа с Redis
        $this->redis->setex('articles:all', $this->cacheTtl, json_encode($articles));

        return $articles;
    }

    public function find(int $id): ?array {
        $stmt = $this->db->prepare(
            "SELECT * FROM articles WHERE id = :id"
        );
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();

        return $result ?: null;
    }

    public function findCached(int $id): ?array {
        $cacheKey = "article:{$id}";
        // Изменена работа с Redis
        $cached = $this->redis->get($cacheKey);

        if ($cached) {
            return json_decode($cached, true);
        }

        $stmt = $this->db->prepare(
            "SELECT * FROM articles WHERE id = :id"
        );
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();

        if ($result) {
            // Изменена работа с Redis
            $this->redis->setex($cacheKey, $this->cacheTtl, json_encode($result));
        }

        return $result ?: null;
    }

    public function update(int $id, array $data): bool {
        $query = "UPDATE articles SET 
                    title = :title, 
                    content = :content
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $data['id'] = $id;
        $success = $stmt->execute($data);
        
        if ($success) {
            // Изменена работа с Redis
            $this->redis->del("article:{$id}");
            $this->redis->del("articles:all");
        }
        
        return $success;
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM articles WHERE id = :id");
        $success = $stmt->execute(['id' => $id]);
        
        if ($success) {
            // Изменена работа с Redis
            $this->redis->del("article:{$id}");
            $this->redis->del("articles:all");
        }
        
        return $success;
    }
}