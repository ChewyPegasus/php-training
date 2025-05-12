<?php
// filepath: d:\prog\php\php-training\redis\app\models\Comment.php
declare(strict_types=1);

namespace App\Models;

class Comment extends Model {
    public function create(array $data): int {
        $query = "INSERT INTO comments (article_id, content, author)
                    VALUES (:article_id, :content, :author) RETURNING id";
        $stmt = $this->db->prepare($query);

        $stmt->execute($data);

        $id = (int) $stmt->fetchColumn(0);

        // Изменена работа с Redis
        $this->redis->del("article:{$data['article_id']}:comments");

        return $id;
    }

    public function find(int $articleId): ?array {
        $stmt = $this->db->prepare(
            "SELECT * FROM comments WHERE article_id = :article_id ORDER BY created_at DESC"
        );

        $stmt->execute(['article_id' => $articleId]);

        $result = $stmt->fetchAll();

        return $result ?: null;
    }

    public function findCached(int $articleId): ?array {
        $cacheKey = "article:{$articleId}:comments";
        // Изменена работа с Redis
        $cached = $this->redis->get($cacheKey);

        if ($cached) {
            return json_decode($cached, true);
        }

        $stmt = $this->db->prepare(
            "SELECT * FROM comments WHERE article_id = :article_id ORDER BY created_at DESC"
        );

        $stmt->execute(['article_id' => $articleId]);

        $result = $stmt->fetchAll();

        if ($result) {
            // Изменена работа с Redis
            $this->redis->setex($cacheKey, $this->cacheTtl, json_encode($result));
        }

        return $result ?: null;
    }

    public function update(int $articleId, int $commentId, array $data): bool {
        $query = "UPDATE comments SET
                    article_id = :article_id,
                    content = :content,
                    author = :author
                  WHERE id = :id";

        $stmt = $this->db->prepare($query);
        $data['id'] = $commentId;
        $success = $stmt->execute($data);

        if ($success) {
            // Изменена работа с Redis
            $this->redis->del("article:{$articleId}:comments");
        }

        return $success;
    }

    public function delete(int $articleId, int $commentId): bool {
        $stmt = $this->db->prepare("DELETE FROM comments WHERE id = :id");
        $success = $stmt->execute(['id' => $commentId]);
        
        if ($success) {
            // Изменена работа с Redis
            $this->redis->del("article:{$articleId}:comments");
        }
        
        return $success;
    }
}