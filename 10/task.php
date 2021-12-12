<?php
    require_once(__DIR__ . '/../input.php');

    $chunkChars = [
        '(' => ')',
        '[' => ']',
        '{' => '}',
        '<' => '>',
    ];
    $scores1 = [
        ')' => 3,
        ']' => 57,
        '}' => 1197,
        '>' => 25137,
    ];

    $scores2 = [
        '(' => 1,
        '[' => 2,
        '{' => 3,
        '<' => 4,
    ];

    $illegalChars = [
        ')' => 0,
        ']' => 0,
        '}' => 0,
        '>' => 0,
    ];

    $scoresForCompletedLines = [];

    foreach ($lines as $line) {
        $chunks = [];
        $length = strlen($line);
        $isLineCorrupted = false;
        for ($x = 0; $x < $length; $x++) {
            if (in_array($line[$x], array_keys($chunkChars))) {
                $chunks[] = [$line[$x]];
            } else {
                $chunksFiltered = array_filter($chunks, function ($chunk) {
                    return count($chunk) === 1;
                });

                $chunkChar = $chunksFiltered[count($chunksFiltered) - 1];

                if ($line[$x] != $chunkChars[$chunkChar[0]]) {
                    $illegalChars[$line[$x]]++;
                    $isLineCorrupted = true;
                    break;
                } else {
                    array_pop($chunks);
                }
            }
        }

        if ($isLineCorrupted) {
            continue;
        }

        $score = 0;
        $reversedChunks = array_reverse($chunks);
        foreach ($reversedChunks as $chunk) {
            $score = $score * 5 + ($scores2[$chunk[0]]);
        }
        $scoresForCompletedLines[] = $score;
    }

    sort($scoresForCompletedLines);

    $answer1 = 0;
    foreach ($illegalChars as $char => $occurences) {
        $answer1 += $scores1[$char] * $occurences;
    }

    $answer2 = $scoresForCompletedLines[(int) count($scoresForCompletedLines) / 2];

    echo sprintf("Answer 1: %d\nAnswer 2: %d\n", $answer1, $answer2);
