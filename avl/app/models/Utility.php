<?php
declare(strict_types=1);

namespace App\Models;

class Utility
{
    public static function generateCommandList(array $commands, int $amount): array
    {
        $weights = [
            'find' => 50,
            'insert' => 20,
            'delete' => 10,
            'inOrder' => 8,
            'preOrder' => 6,
            'postOrder' => 6
        ];
        
        $weightedCommands = [];
        foreach ($weights as $cmd => $weight) {
            if (in_array($cmd, $commands)) {
                for ($i = 0; $i < $weight; $i++) {
                    $weightedCommands[] = $cmd;
                }
            }
        }
        
        $result = [];
        $totalWeights = count($weightedCommands);
        
        for ($i = 0; $i < $amount; ++$i) {
            $cmd = $weightedCommands[rand(0, $totalWeights - 1)];
            
            switch ($cmd) {
                case 'find':
                case 'insert':
                case 'delete':
                    $x = rand(0, 1000);
                    $result[] = [
                        'cmd' => $cmd, 
                        'arg' => $x,
                    ];
                    break;
                    
                case 'inOrder':
                case 'preOrder':
                case 'postOrder':
                    $result[] = [
                        'cmd' => $cmd,
                    ];
                    break;
            }
        }
        
        return $result;
    }

    public static function execCommand($tree, array $command, array &$results): float
    {
        $start = microtime(true);
        
        $method = $command['cmd'];
        
        if (in_array($method, ['find', 'insert', 'delete'])) {
            $x = $command['arg'];
            $result = $tree->$method($x);
            
            if ($method === 'find') {
                $result = $result ? true : false;
            }

            $results[] = [$method, $x, $result];
        } else {
            $result = $tree->$method();
            $results[] = [$method, $result];
        }
        
        $end = microtime(true);
        return $end - $start;
    }
}
