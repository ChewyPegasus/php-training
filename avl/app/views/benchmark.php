<?php
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AVL Benchmark Results</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        th { background-color: #4CAF50; color: white; }
        .improvement-good { color: green; font-weight: bold; }
        .improvement-bad { color: red; font-weight: bold; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>AVL vs AVL с кэшированием - Сравнение производительности</h2>
        <p>Всего операций: <?= $commandsAmount ?></p>

        <h3>Распределение команд:</h3>
        <table>
            <tr>
                <th>Команда</th>
                <th>Количество</th>
                <th>Процент</th>
            </tr>
            <?php foreach ($countByCommand as $cmd => $count): ?>
                <tr>
                    <td><?= $cmd ?></td>
                    <td><?= $count ?></td>
                    <td><?= round(($count / $commandsAmount) * 100, 2) ?>%</td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h3>Сравнение по типам команд (в секундах):</h3>
        <table>
            <tr>
                <th>Тип команды</th>
                <th>AVL</th>
                <th>AVL с кэшированием</th>
                <th>Улучшение</th>
            </tr>
            <?php foreach ($timeByCommand['avl'] as $cmd => $avlTime): ?>
                <?php 
                    $cachedTime = $timeByCommand['cached'][$cmd];
                    
                    if ($avlTime > 0) {
                        $improvement = ($avlTime - $cachedTime) / $avlTime * 100;
                        $improvementClass = $improvement > 0 ? 'improvement-good' : 'improvement-bad';
                        $improvementText = round($improvement, 2) . '%';
                    } else {
                        $improvement = 0;
                        $improvementClass = '';
                        $improvementText = 'N/A';
                    }
                ?>
                <tr>
                    <td><?= $cmd ?></td>
                    <td><?= round($avlTime, 6) ?></td>
                    <td><?= round($cachedTime, 6) ?></td>
                    <td class="<?= $improvementClass ?>"><?= $improvementText ?></td>
                </tr>
            <?php endforeach; ?>
            <?php
                $totalImprovement = ($totalTime['avl'] > 0) 
                    ? (($totalTime['avl'] - $totalTime['cached']) / $totalTime['avl'] * 100) 
                    : 0;
                $totalImprovementClass = $totalImprovement > 0 ? 'improvement-good' : 'improvement-bad';
            ?>
            <tr>
                <td><strong>Общее время</strong></td>
                <td><strong><?= round($totalTime['avl'], 6) ?></strong></td>
                <td><strong><?= round($totalTime['cached'], 6) ?></strong></td>
                <td class="<?= $totalImprovementClass ?>"><strong><?= round($totalImprovement, 2) ?>%</strong></td>
            </tr>
        </table>

        <h3>Визуальное сравнение:</h3>
        <div style="width: 100%; height: 300px; margin-bottom: 20px;">
            <canvas id="performanceChart"></canvas>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const ctx = document.getElementById("performanceChart");
                
                new Chart(ctx, {
                    type: "bar",
                    data: {
                        labels: ["<?= implode('", "', array_keys($timeByCommand['avl'])) ?>", "Общее время"],
                        datasets: [
                            {
                                label: "AVL",
                                data: [<?= implode(', ', array_map(function($val) { return round($val, 6); }, array_values($timeByCommand['avl']))) ?>, <?= round($totalTime['avl'], 6) ?>],
                                backgroundColor: "rgba(54, 162, 235, 0.5)",
                                borderColor: "rgba(54, 162, 235, 1)",
                                borderWidth: 1
                            },
                            {
                                label: "AVL с кэшированием",
                                data: [<?= implode(', ', array_map(function($val) { return round($val, 6); }, array_values($timeByCommand['cached']))) ?>, <?= round($totalTime['cached'], 6) ?>],
                                backgroundColor: "rgba(255, 99, 132, 0.5)",
                                borderColor: "rgba(255, 99, 132, 1)",
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: "Время (сек)"
                                }
                            }
                        },
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: "Сравнение времени выполнения операций"
                            },
                            legend: {
                                position: "top"
                            }
                        }
                    }
                });
            });
        </script>
    </div>
</body>
</html>