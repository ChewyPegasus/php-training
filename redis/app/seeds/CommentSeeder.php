<?php

namespace App\Seeds;

use App\Database\Seeder;
use PDOException;

class CommentSeeder extends Seeder {

    protected function generate(int $articleId): array {
        $data = [];
        $commentsCount = rand(1, 100);
        for ($j = 0; $j < $commentsCount; ++$j) {
            $data[] = [
                'article_id' => $articleId,
                'content' => $this->faker->paragraph(rand(1, 3)),
                'author' => $this->faker->name
            ];
        }
        return $data;
    }

    public function run(): void {
        $this->truncate('articles');

        $articles = $this->db->query(
            "SELECT id FROM articles"
        )->fetchAll(\PDO::FETCH_COLUMN);

        $stmt = $this->db->prepare(
            "INSERT INTO comments (article_id, content, author)
                VALUES (:article_id, :content, :author)"
        );

        echo "Starting comment generation";
        $startTime = microtime(true);

        foreach ($articles as $id) {
            try {
                $this->db->beginTransaction();
                $comments = $this->generate($id);
                $stmt->execute($comments);
                $this->db->commit();
            } catch (\PDOException $e) {
                $this->db->rollBack();
                echo "Failed: " . $e->getMessage() . "\n";
            }
        }

        $time = microtime(true) - $startTime;
        echo "Data generation completed in " . round($time, 2) . " seconds\n";
    }
}