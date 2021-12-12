<?php
    require_once(__DIR__ . '/../input.php');

    $energylevels = [];
    foreach ($lines as $line) {
        $energylevels[] = array_map(function ($x) {
            return (int) $x;
        }, str_split($line));
    }

    $totalEnergyLevels = count($energylevels);
    $totalEnergyLevelsFirst = count($energylevels[0]);

    $flashes = 0;
    function flash($a, $b)
    {
        global $flashes, $energylevels, $totalEnergyLevels, $totalEnergyLevelsFirst;

        $flashes++;
        $energylevels[$a][$b] = -1;

        foreach ([-1, 0, 1] as $da) {
            foreach ([-1, 0, 1] as $db) {
                $aa = $a + $da;
                $bb = $b + $db;
                if ((0 <= $aa && $aa < $totalEnergyLevels) && (0 <= $bb && $bb < $totalEnergyLevelsFirst) && $energylevels[$aa][$bb] != -1) {
                    $energylevels[$aa][$bb]++;

                    if ($energylevels[$aa][$bb] >= 10) {
                        flash($aa, $bb);
                    }
                }
            }
        }
    }

    $rangeLines = range(0, $totalEnergyLevels - 1);
    $rangeCols = range(0, $totalEnergyLevelsFirst - 1);

    $answer1 = 0;
    $answer2 = 0;

    $isDone = false;
    do {
        $answer2++;
        foreach ($rangeLines as $a) {
            foreach ($rangeCols as $b) {
                $energylevels[$a][$b]++;
            }
        }

        foreach ($rangeLines as $a) {
            foreach ($rangeCols as $b) {
                if ($energylevels[$a][$b] == 10) {
                    flash($a, $b);
                }
            }
        }

        $isDone = true;

        foreach ($rangeLines as $a) {
            foreach ($rangeCols as $b) {
                if ($energylevels[$a][$b] == -1) {
                    $energylevels[$a][$b] = 0;
                } else {
                    $isDone = false;
                }
            }
        }

        if ($answer2 == 100) {
            $answer1 = $flashes;
        }
    } while (!$isDone);

    echo sprintf("Answer 1: %d\nAnswer 2: %d\n", $answer1, $answer2);
