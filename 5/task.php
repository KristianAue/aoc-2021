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

    $p1 = $p2 = [];

    foreach($lines as $line){
        list($start, $end) = explode('->', $line, 2);
        list($x1, $y1) = explode(',', $start, 2);
        list($x2, $y2) = explode(',', $end, 2);

        $x1 = (int) trim($x1);
        $x2 = (int) trim($x2);
        $y1 = (int) trim($y1);
        $y2 = (int) trim($y2);

        $dx = $x2-$x1;
        $dy = $y2-$y1;

        foreach(range(0, max(abs($dx), abs($dy))) as $i) {
            $x = $x1 + ($dx > 0 ? 1 : ($dx < 0 ? -1 : 0)) * $i;
            $y = $y1 + ($dy > 0 ? 1 : ($dy < 0 ? -1 : 0)) * $i;

            if($dx == 0 || $dy == 0) {
                if(!isset($p1[$x][$y])) {
                    $p1[$x][$y] = 0;
                }

                $p1[$x][$y]++;
            }

            if(!isset($p2[$x][$y])) {
                $p2[$x][$y] = 0;
            }

            $p2[$x][$y]++;
        }
    }

    $answer1 = 0;
    $answer2 = 0;

    foreach($p1 as $points) {
        foreach($points as $point) {
            if($point > 1) {
                $answer1++;
            }
        }
    }

    foreach($p2 as $points) {
        foreach($points as $point) {
            if($point > 1) {
                $answer2++;
            }
        }
    }

    echo sprintf("Answer 1: %d\nAnswer 2: %d\n", $answer1, $answer2);
