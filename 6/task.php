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
    
    $input = array_values(array_map(function ($fish) {
        return (int) $fish;
    }, explode(',', $lines[0])));

    $initial = [
        0 => 0,
        1 => 0,
        2 => 0,
        3 => 0,
        4 => 0,
        5 => 0,
        6 => 0,
        7 => 0,
        8 => 0,
    ];
    $lanternfish = $initial;

    // Setup array from input
    foreach ($input as $n) {
        if (!isset($lanternfish[$n])) {
            $lanternfish[$n] = 0;
        }
        $lanternfish[$n]++;
    }

    $answer1 = 0;
    $answer2 = 0;

    // Simulate 256 days
    foreach (range(1, 256) as $day) {
        $new = $initial;
        foreach ($lanternfish as $fish => $count) {
            if ($fish == 0) {
                $new[6] += $count;
                $new[8] += $count;
            } else {
                $new[$fish-1] += $count;
            }
        }

        $lanternfish = $new;

        // Part 1
        if ($day == 80) {
            $answer1 = array_sum($lanternfish);
        }
    }

    // Part 2
    $answer2 = array_sum($lanternfish);

    echo sprintf("Answer 1: %d\nAnswer 2: %d\n", $answer1, $answer2);
