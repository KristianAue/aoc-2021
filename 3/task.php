<?php
    require_once(__DIR__ . '/../input.php');

    // Find length of bits
    $bitchars = strlen($lines[0]);

    $totalLines = count($lines);

    $gamma = $epsilon = $oxygen = $scrubber = '';

    // Look through length of bits, then each line
    for ($c = 0; $c < $bitchars; $c++) {
        $bits = [0, 0];
        for ($l = 0; $l < $totalLines; $l++) {
            if ($lines[$l][$c] == 0) {
                $bits[0]++;
            } else {
                $bits[1]++;
            }
        }

        if ($bits[0] > $bits[1]) {
            $epsilon .= '0';
            $gamma .= '1';
        } else {
            $epsilon .= '1';
            $gamma .= '0';
        }
    }

    $oxygenbits = $scrubberbits = $lines;

    function findOxygen($bits, $char = 0)
    {
        $bitlength = strlen($bits[0]);
        $foundBits = [];
        $common = [0, 0];
        foreach ($bits as $bit) {
            if ($bit[$char] == 0) {
                $common[0]++;
            } else {
                $common[1]++;
            }
        }

        foreach ($bits as $bit) {
            if (($common[0] > $common[1] && $bit[$char] == 0) || ($common[0] <= $common[1] && $bit[$char] == 1)) {
                $foundBits[] = $bit;
            }
        }

        if (count($foundBits) > 1) {
            return findOxygen($foundBits, ++$char);
        }

        return $foundBits[0];
    }

    function findScrubber($bits, $char = 0)
    {
        $bitlength = strlen($bits[0]);
        $foundBits = [];
        $common = [0, 0];
        foreach ($bits as $bit) {
            if ($bit[$char] == 0) {
                $common[0]++;
            } else {
                $common[1]++;
            }
        }

        foreach ($bits as $bit) {
            if (($common[0] <= $common[1] && $bit[$char] == 0) || ($common[0] > $common[1] && $bit[$char] == 1)) {
                $foundBits[] = $bit;
            }
        }

        if (count($foundBits) > 1) {
            return findScrubber($foundBits, ++$char);
        }

        return $foundBits[0];
    }

    $answer1 = bindec($epsilon) * bindec($gamma);
    $answer2 = bindec(findOxygen($lines)) * bindec(findScrubber($lines));

    echo sprintf("Answer 1: %d\nAnswer 2: %d\n", $answer1, $answer2);
