<?php
    require_once(__DIR__ . '/../input.php');

    $input = array_values(array_map(function ($fish) {
        return (int) $fish;
    }, explode(',', $lines[0])));

    // First, sort array
    sort($input);

    // Retrieve median
    $median = $input[(int) count($input) / 2];
    $answer1 = 0;
    foreach ($input as $crab) {
        if ($crab < $median) {
            $answer1 += $median - $crab;
        } elseif ($crab > $median) {
            $answer1 += $crab - $median;
        }
    }

    $range = range(0, max($input) - min($input));

    $answer2 = null;
    foreach ($range as $i) {
        $score = 0;

        foreach ($input as $crab) {
            $abs = abs($crab - $i);
            $score += $abs * ($abs + 1) / 2;
        }

        if ($answer2 === null || $score < $answer2) {
            $answer2 = $score;
        }
    }

    echo sprintf("Answer 1: %d\nAnswer 2: %d\n", $answer1, $answer2);
