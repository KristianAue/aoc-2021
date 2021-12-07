<?php
    ini_set('memory_limit', -1);
    $handle = fopen(__DIR__ . '/input.txt', 'r');

    $lines = [];

    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            $lines[] = rtrim($line, "\r\n");
        }

        fclose($handle);
    }

    $boards = [];
    $possibleSolutions = [];

    $totalLines = count($lines);

    for($x = 2; $x < $totalLines; $x += 6) {
        $board = array_map(function($line) {
            return array_values(array_map(function($number) {
                return (int) $number;
            }, array_filter(explode(' ', $line), function($number) {
                return $number !== '';
            })));


            return array_values(array_filter(array_map(function($number) {
                return (int) $number;
            }, explode(' ', $line)), function($number) {
                return $number !== 0;
            }));
        }, array_slice($lines, $x, 5));

        $boards[] = $board;

        $solutions = [];

        foreach($board as $key => $line) {
            $solutions[] = [
                $line[0], $line[1], $line[2], $line[3], $line[4],
            ];
            $solutions[] = [
                $board[0][$key], $board[1][$key], $board[2][$key], $board[3][$key], $board[4][$key],
            ];
        }

        $possibleSolutions[] = $solutions;
    }

    $numbers = explode(',', $lines[0]);
    $chosenNumbers = [];
    $foundSolution = null;
    $winningBoards = [];
    $foundLastSolution = null;

    $answer1 = 0;
    $answer2 = 0;
    
    foreach($numbers as $n => $number) {
        $number = (int) $number;
        
        $chosenNumbers[] = $number;

        if(count($chosenNumbers) < 5) {
            continue;
        }

        foreach($boards as $key => $board) {
            $solutions = $possibleSolutions[$key];

            foreach($solutions as $solution) {
                if(count(array_diff($solution, $chosenNumbers)) === 0) {
                    // Answer 1
                    if($answer1 === 0) {
                        foreach($board as $solution) {
                            foreach($solution as $s) {
                                if(!in_array($s, $chosenNumbers)) {
                                    $answer1 += $s;
                                }
                            }
                        }

                        $answer1 *= $chosenNumbers[$n];
                    }

                    // Answer 2
                    $foundLastSolution = $board;
                    if(!in_array($board, $winningBoards)) {
                        $winningBoards[] = $board;
                    }
                    
                    if(count($winningBoards) === count($boards)) {
                        foreach($board as $solution) {
                            foreach($solution as $s) {
                                if(!in_array($s, $chosenNumbers)) {
                                    $answer2 += $s;
                                }
                            }
                        }

                        $answer2 *= $chosenNumbers[$n];
                        break 3;
                    }
                }
            }
        }
    }

    echo sprintf("Answer 1: %d\nAnswer 2: %d\n", $answer1, $answer2);
