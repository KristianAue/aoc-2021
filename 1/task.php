<?php
    require_once(__DIR__ . '/../input.php');

    $lines = array_map(function ($line) {
        return (int) $line;
    }, $lines);

    $totalLines = count($lines);

    $answer1 = 0;
    $answer2 = 0;

    for ($x = 1; $x < $totalLines; $x++) {
        if ($lines[$x-1] < $lines[$x]) {
            $answer1++;
        }

        // Part 2
        if ($x-1 > 0 && $x < $totalLines-1) {
            $sumWindowPreviousIteration = $lines[$x-2] + $lines[$x-1] + $lines[$x];
            $sumWindow = $lines[$x-1] + $lines[$x] + $lines[$x+1];

            if ($sumWindow > $sumWindowPreviousIteration) {
                $answer2++;
            }
        }
    }

    echo sprintf("Answer 1: %d\nAnswer 2: %d\n", $answer1, $answer2);
