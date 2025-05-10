<?php

declare(strict_types=1);

namespace App\Models;

use PDO;
use App\Database\PostgresConnection;

class Comment extends Model {
    public function create(array $data): int {
        $query = "INSERT INTO comments (article_id, content, author)
                    VALUES (:article_id, :content, :author) RETURNING id";
        $stmt = $this->db->prepare($query);

        $stmt->execute($data);

        $id = (int) $stmt->fetchColumn(0);

        $this->redis->del("comments:{$data['article_id']}");

        return (int) $stmt->fetchColumn();
    }

    public function find(int $articleId): ?array {
        $cacheKey = "comments:{$articleId}";
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
            $this->redis->setex($cacheKey, $this->cacheTtl, $result);
        }

        return $result ?: null;
    }

    public function update(int $articleId, int $commentId, array $data): bool {
        $query = "UPDATE comments SET
                    article_id = :article_id,
                    content = :content,
                    author = :author";
        $stmt = $this->db->prepare($query);
        $data['id'] = $commentId;
        $success = $stmt->execute($data);

        if ($success) {
            $this->redis->del("comments:{$articleId}");
        }

        return $success;
    }

    public function delete(int $articleId, int $commentId): bool {
        $stmt = $this->db->prepare("DELETE FROM comments WHERE id = :id");
        $success = $stmt->execute(['id' => $commentId]);
        
        if ($success) {
            $this->redis->del("comments:{$articleId}");
        }
        
        return $success;
    }
}