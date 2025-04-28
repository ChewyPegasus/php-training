
<?php

require __DIR__ . '/config.php';
require __DIR__ . '/../vendor/autoload.php';

$faker = Faker\Factory::create();
$pdo = getConnection();

$batch = 10000;
$total = 100000;
$batches = ceil($total / $batch);

echo "Starting data generation: $total records in batches of $batch\n";

$query = "
    INSERT INTO products (product_name, supplier_id, category_id, quantity_per_unit, unit_price, units_in_stock, units_on_order, reorder_level, discontinued, rating, creation_date)
    VALUES (:product_name, :supplier_id, :category_id, :quantity_per_unit, :unit_price, :units_in_stock, :units_on_order, :reorder_level, :discontinued, :rating, :creation_date)
";

$stmt = $pdo->prepare($query);

$startTime = microtime(true);
$recordsInserted = 0;

try {
    for ($i = 0; $i < $batches; ++$i) {
        $pdo->beginTransaction();

        if ($total - $recordsInserted < $batch) {
            $batch = $total - $recordsInserted;
        }
        for ($j = 0; $j < $batch; ++$j) {
            $productName = $faker->word . ' ' . $faker->word;
            $supplierId = $faker->numberBetween(1, 10);
            $categoryId = $faker->numberBetween(1, 10);
            $quantityPerUnit = $faker->numberBetween(1, 10) . ' ' . $faker->randomElement(['boxes', 'bottles', 'pieces', 'units']);
            $unitPrice = $faker->numberBetween(1, 10000) / 100;
            $unitsInStock = $faker->numberBetween(0, 100);
            $unitsOnOrder = $faker->numberBetween(0, 50);
            $reorderLevel = $faker->numberBetween(0, 20);
            $discontinued = $faker->boolean(0.5) ? "true" : "false";
            $rating = $faker->numberBetween(1, 5);
            $creationDate = $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s');

            $stmt->execute([
                ':product_name' => $productName,
                ':supplier_id' => $supplierId,
                ':category_id' => $categoryId,
                ':quantity_per_unit' => $quantityPerUnit,
                ':unit_price' => $unitPrice,
                ':units_in_stock' => $unitsInStock,
                ':units_on_order' => $unitsOnOrder,
                ':reorder_level' => $reorderLevel,
                ':discontinued' => $discontinued,
                ':rating' => $rating,
                ':creation_date' => $creationDate
            ]);
        }

        $pdo->commit();
        $recordsInserted += $batch;
        echo "Inserted $recordsInserted records\n";
    }
    $time = microtime(true) - $startTime;
    echo "Data generation completed in " . round($time, 2) . " seconds\n";
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Failed: " . $e->getMessage() . "\n";
} finally {
    $pdo = null;
}