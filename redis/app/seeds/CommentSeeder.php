<?php

namespace App\Seeds;

use App\Seeds\Seeder;
use PDOException;

class CommentSeeder extends Seeder {

    protected function generate(int $articleId): array {
        $data = [];
        $commentsCount = rand(1, 10);
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
        $this->truncate('comments');

        $articles = $this->db->query(
            "SELECT id FROM articles"
        )->fetchAll(\PDO::FETCH_COLUMN);

        $stmt = $this->db->prepare(
            "INSERT INTO comments (article_id, content, author)
                VALUES (:article_id, :content, :author)"
        );

        echo "Starting comment generation<br>";
        $startTime = microtime(true);

        $totalComments = 0;
        $count = 0;

        foreach ($articles as $id) {
            try {
                $this->db->beginTransaction();
                $comments = $this->generate($id);
                
                foreach ($comments as $comment) {
                    $stmt->execute($comment);
                    $totalComments++;
                }
                
                $this->db->commit();
                
                $count++;
                if ($count % 100 === 0) {
                    echo "Processed $count articles, $totalComments comments so far<br>";
                }
            } catch (\PDOException $e) {
                $this->db->rollBack();
                echo "Failed: " . $e->getMessage() . "<br>";
            }
        }

        $time = microtime(true) - $startTime;
        echo "Data generation completed in " . round($time, 2) . " seconds\n";
    }
}