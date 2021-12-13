<?php
    require_once(__DIR__ . '/../input.php');

    $caves = [];

    foreach ($lines as $line) {
        list($a, $b) = explode('-', $line, 2);

        $caves[$a][] = $b;
        $caves[$b][] = $a;
    }

    function solve($part)
    {
        global $caves;
        $answer = 0;

        $path = [['start', ['start'], null]];
        while (count($path) > 0) {
            list($pos, $small, $twice) = array_shift($path);

            if ($pos === 'end') {
                $answer++;
                continue;
            }

            foreach ($caves[$pos] as $cave) {
                if (!in_array($cave, $small)) {
                    $nsmall = $small;
                    if (strtolower($cave) == $cave) {
                        $nsmall[] = $cave;
                    }

                    $path[] = [$cave, $nsmall, $twice];
                } elseif (in_array($cave, $small) && $twice === null && !in_array($cave, ['start', 'end']) && $part === 2) {
                    $path[] = [$cave, $small, $cave];
                }
            }
        }

        return $answer;
    }

    $answer1 = solve(1);
    $answer2 = solve(2);

    echo sprintf("Answer 1: %d\nAnswer 2: %d\n", $answer1, $answer2);
