<?php
declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\AVL;
use App\Models\Wrapper;
use App\Models\Utility;

class BenchmarkController {
    public function runBenchmark(int $commandsAmount): void
    {
        $commands = [
            'find', 
            'postOrder', 
            'inOrder', 
            'preOrder', 
            'insert', 
            'delete',
        ];
        $commandsList = Utility::generateCommandList(
            commands: $commands, 
            amount: $commandsAmount,
        );

        $avl = new AVL();
        $cachingAVL = new Wrapper();

        $timeByCommand = [
            'avl' => [
                'find' => 0, 
                'insert' => 0, 
                'delete' => 0, 
                'inOrder' => 0, 
                'preOrder' => 0, 
                'postOrder' => 0
            ],
            'cached' => [
                'find' => 0, 
                'insert' => 0, 
                'delete' => 0, 
                'inOrder' => 0, 
                'preOrder' => 0, 
                'postOrder' => 0,
            ]
        ];
        
        $countByCommand = [
            'find' => 0, 
            'insert' => 0, 
            'delete' => 0, 
            'inOrder' => 0, 
            'preOrder' => 0, 
            'postOrder' => 0,
        ];
        
        $result = [
            'avl' => [], 
            'cached' => [],
        ];

        for ($i = 0; $i < $commandsAmount; ++$i) {
            $cmd = $commandsList[$i]['cmd'];
            $countByCommand[$cmd]++;
            
            $timeByCommand['avl'][$cmd] += Utility::execCommand(
                tree: $avl, 
                command: $commandsList[$i], 
                results: $result['avl']
            );
            $timeByCommand['cached'][$cmd] += Utility::execCommand(
                tree: $cachingAVL, 
                command: $commandsList[$i], 
                results: $result['cached'],
            );
        }

        assert(
            count($result['avl']) === count($result['cached']), 
            'size must be equal'
        );
        for ($i = 0; $i < count($result['avl']); ++$i) {
            if ($result['avl'][$i] !== $result['cached'][$i]) {
                echo sprintf('Mismatch at index %:<br>', $i);
                echo 'AVL result: ' . print_r($result['avl'][$i], true) . '<br>';
                echo 'Cached result: ' . print_r($result['cached'][$i], true) . '<br>';
                break;
            }
        }

        $totalTime = [
            'avl' => array_sum(array_values($timeByCommand['avl'])),
            'cached' => array_sum(array_values($timeByCommand['cached']))
        ];

        $data = [
            'commandsAmount' => $commandsAmount,
            'countByCommand' => $countByCommand,
            'timeByCommand' => $timeByCommand,
            'totalTime' => $totalTime,
            'avl' => $avl,
            'cachingAVL' => $cachingAVL
        ];

        require_once __DIR__ . '/../views/benchmark.php';
    }
}
