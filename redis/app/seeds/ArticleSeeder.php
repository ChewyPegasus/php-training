<?php

namespace App\Seeds;

use App\Seeds\Seeder;

class ArticleSeeder extends Seeder 
{
    protected function generate(int $batch): array 
    {
        $data = [];
        for ($j = 0; $j < $batch; ++$j) {
            $data[] = [
                'title' => $this->faker->sentence(rand(1, 10)),
                'content' => $this->faker->paragraphs(rand(1, 10), true)
            ];
        }
        return $data;
    }

    public function run(): void 
    {
        $this->truncate('articles');

        $batch = 100;
        $total = 1000;
        $batches = ceil($total / $batch);

        echo sprintf('Starting article generation: %d records in batches of %d<br>', $total, $batch);

        $query = '
            INSERT INTO articles (title, content)
            VALUES (:title, :content)
        ';

        $stmt = $this->db->prepare($query);

        $startTime = microtime(true);
        $recordsInserted = 0;

        try {
            for ($i = 0; $i < $batches; ++$i) {
                $this->db->beginTransaction();

                if ($total - $recordsInserted < $batch) {
                    $batch = $total - $recordsInserted;
                }

                $data = $this->generate($batch);

                foreach ($data as $datum) {
                    $stmt->execute($datum);
                }

                $this->db->commit();

                $recordsInserted += $batch;
                echo sprintf('Inserted %d records<br>', $recordsInserted);
            }
            $time = microtime(true) - $startTime;
            echo 'Data generation completed in ' . round($time, 2) . ' seconds<br>';
        } catch (\Exception $e) {
            $this->db->rollBack();
            echo 'Failed: ' . $e->getMessage() . '<br>';
        }
    }
}