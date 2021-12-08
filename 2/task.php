<?php
    require_once(__DIR__ . '/../input.php');

    $totalLines = count($lines);

    $horizontal = 0;
    $depth = [0, 0];
    $aim = 0;

    for ($x = 0; $x < $totalLines; $x++) {
        $parts = explode(' ', $lines[$x], 2);

        if ($parts[0] === 'forward') {
            $horizontal += $parts[1];
            $depth[1] += $aim * $parts[1];
        } elseif ($parts[0] === 'up') {
            $depth[0] = $aim -= $parts[1];
        } elseif ($parts[0] === 'down') {
            $depth[0] = $aim += $parts[1];
        }
    }
    
    $answer1 = $horizontal * $depth[0];
    $answer2 = $horizontal * $depth[1];

    echo sprintf("Answer 1: %d\nAnswer 2: %d\n", $answer1, $answer2);
