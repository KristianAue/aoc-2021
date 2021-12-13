<?php
    require_once(__DIR__ . '/../input.php');

    $instructions = [];

    $dots = [];

    foreach ($lines as $line) {
        if (empty($line)) {
            continue;
        }

        if (strpos($line, 'fold along') !== false) {
            // Instruction
            $instruction = str_replace('fold along ', '', $line);

            list($axis, $instruction) = explode('=', $instruction, 2);

            $instructions[] = [$axis, (int) $instruction];
        } else {
            // Dot
            list($x, $y) = explode(',', $line, 2);

            $dots[] = [(int) $x, (int) $y];
        }
    }

    $answer1 = 0;
    foreach ($instructions as $i) {
        foreach ($dots as $key => $dot) {
            list($x, $y) = $dot;
            if ($i[0] === 'x' && $i[1] < $x) {
                $new = [$i[1] - ($x - $i[1]), $y];
            } elseif ($i[0] === 'y' && $i[1] < $y) {
                $new = [$x, $i[1] - ($y - $i[1])];
            } else {
                continue;
            }

            $s = current(array_filter($dots, function ($d) use ($new) {
                return $d[0] === $new[0] && $d[1] === $new[1];
            }));

            if (!$s) {
                $dots[$key] = $new;
            } else {
                unset($dots[$key]);
            }
        }

        if ($answer1 === 0) {
            $answer1 = count($dots);
        }
    }

    $max = [
        max(array_map(function ($coords) {
            return $coords[0];
        }, $dots)),
        max(array_map(function ($coords) {
            return $coords[1];
        }, $dots)),
    ];
    echo sprintf("Answer 1: %d\nAnswer 2:\n", $answer1);
    $answer2 = '';

    foreach (range(0, $max[1] + 1) as $y) {
        foreach (range(0, $max[0] + 1) as $x) {
            $s = current(array_filter($dots, function ($dot) use ($x, $y) {
                return $dot[0] === $x && $dot[1] === $y;
            }));

            if ($s) {
                $answer2 .= '#';
            } else {
                $answer2 .= ' ';
            }
        }
        echo $answer2 . "\n";
        $answer2 = '';
    }
