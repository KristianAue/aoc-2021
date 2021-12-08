<?php
    require_once(__DIR__ . '/../input.php');

    $segments = [
        0 => 'abcef',
        1 => 'cf',
        2 => 'acdeg',
        3 => 'acdfg',
        4 => 'bcdf',
        5 => 'abdfg',
        6 => 'abdefg',
        7 => 'acf',
        8 => 'abcdefg',
        9 => 'abcdfg',
    ];

    error_reporting(0);

    function findSegments($parts)
    {
        // Array to store final segments in
        $finalSegments = [];

        // Find word that is 2 characters long from input
        $word = '';
        foreach ($parts as $p) {
            if (strlen($p) == 2) {
                $word = $p;
            }
        }

        // Loop through every word and find words that are 6 characters long, and specify segments f and c based on position of $word
        foreach ($parts as $p) {
            if (strlen($p) == 6 && (strpos($p, $word[0]) !== false) != (strpos($p, $word[1]) !== false)) {
                if (strpos($p, $word[0]) !== false) {
                    $finalSegments[$word[0]] = 'f';
                    $finalSegments[$word[1]] = 'c';
                } else {
                    $finalSegments[$word[0]] = 'c';
                    $finalSegments[$word[1]] = 'f';
                }
            }
        }

        // Loop through every word and find words that are 3 characters long, and specify segment a based on position of $word
        foreach ($parts as $p) {
            if (strlen($p) == 3) {
                for ($x = 0; $x < strlen($p); $x++) {
                    if (!(strpos($word, $p[$x]) !== false)) {
                        $finalSegments[$p[$x]] = 'a';
                    }
                }
            }
        }

        // Loop through every word and find a word that is 4 characters long, and store letter(s) in $word2 variable for use later
        foreach ($parts as $p) {
            if (strlen($p) == 4) {
                $word2 = '';
                for ($x = 0; $x < strlen($p); $x++) {
                    if (!(strpos($word, $p[$x]) !== false)) {
                        $word2 .= $p[$x];
                    }
                }
            }
        }

        // Loop through every word in input, and compare 6 character words to $word2 variable created above, to create segments b and d
        foreach ($parts as $p) {
            if (strlen($p) == 6 and (strpos($p, $word2[0]) !== false) != (strpos($p, $word2[1]) !== false)) {
                if (strpos($p, $word2[0]) !== false) {
                    $finalSegments[$word2[0]] = 'b';
                    $finalSegments[$word2[1]] = 'd';
                } else {
                    $finalSegments[$word2[1]] = 'b';
                    $finalSegments[$word2[0]] = 'd';
                }
            }
        }

        $missingSegments = '';

        // Loop through every character and append missing segments to $missingSegments for use in final loop
        foreach (['a', 'b', 'c', 'd', 'e', 'f', 'g'] as $char) {
            if (!isset($finalSegments[$char])) {
                $missingSegments .= $char;
            }
        }

        // Loop through every word in input, and find words that are 6 characters long, to compare to missing segments. If found, add segments g and e
        foreach ($parts as $p) {
            if (strlen($p) == 6 && (strpos($p, $missingSegments[0]) !== false) != (strpos($p, $missingSegments[1]) !== false)) {
                if (strpos($p, $eg[0]) !== false) {
                    $finalSegments[$missingSegments[0]] = 'g';
                    $finalSegments[$missingSegments[1]] = 'e';
                } else {
                    $finalSegments[$missingSegments[1]] = 'g';
                    $finalSegments[$missingSegments[0]] = 'e';
                }
            }
        }

        return $finalSegments;
    }

    // Array of unique segment codes
    $unique = [1, 4, 7, 8];

    // Initiate variables for both answers
    $answer1 = 0;
    $answer2 = 0;

    // Go through every line
    foreach ($lines as $line) {
        // Explode parts using separator
        $parts = explode('|', $line, 2);

        // Explode all words on left hand side of separator into signal
        $signal = explode(' ', $parts[0]);

        // Find all segments based on signal input using a method
        $signalSegments = findSegments($signal);

        // Explode all words on right hand side of separator into output
        $output = explode(' ', $parts[1]);

        // Generate stringified answer (to ensure that numbers are appended instead of added)
        $stringifiedAnswer = '';

        // Loop through every word in output
        foreach ($output as $word) {
            // Assigning segment codes to $perm based on signal segments generated in method
            $perm = '';
            foreach (str_split($word) as $w) {
                $perm .= $signalSegments[$w];
            }
            // Splitting, sorting and imploding $perm to ensure it is in alphabetically order, to make it easier to compare with segments
            $perm = str_split($perm);
            sort($perm);
            $perm = implode('', $perm);

            // Generate array of potential segments by using $perm
            $string = [];
            foreach ($segments as $key => $segment) {
                if ($segment == $perm) {
                    $string[] = $key;
                }
            }

            // If found segments is not 1, go to next element in loop
            if (count($string) != 1) {
                continue;
            }

            // If segment is one of the unique numbers, we should increase part 1 answer by 1
            if (in_array($string[0], $unique)) {
                $answer1++;
            }

            // Append number of segment to a string
            $stringifiedAnswer .= (string) $string[0];
        }

        // Increase answer to part 2 by stringified segments
        $answer2 += (int) $stringifiedAnswer;
    }

    echo sprintf("Answer 1: %d\nAnswer 2: %d\n", $answer1, $answer2);
