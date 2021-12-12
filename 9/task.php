<?php
    require_once(__DIR__ . '/../input.php');

    $totalLines = count($lines);

    function retrieveNeighbours($x, $y)
    {
        global $lines, $totalLines;
        $neighbours = [];
        if ($y > 0) {
            $neighbours[] = [$x, $y - 1];
        }

        if ($y < $totalLines - 1) {
            $neighbours[] = [$x, $y + 1];
        }

        if ($x > 0) {
            $neighbours[] = [$x - 1, $y];
        }

        if ($x < strlen($lines[$y]) - 1) {
            $neighbours[] = [$x + 1, $y];
        }

        return $neighbours;
    }

    function mapArray($array)
    {
        return array_map(function ($a) {
            return $a[0] . ',' . $a[1];
        }, $array);
    }

    function calculateBasin($points, $basin = [])
    {
        global $lines;

        foreach ($points as $point) {
            list($x, $y) = [$point[0], $point[1]];

            if ($lines[$y][$x] == 9) {
                continue;
            }

            if (!in_array([$x, $y], $basin)) {
                $basin[] = [$x, $y];
            }

            $neighbours = retrieveNeighbours($x, $y);

            $mappedBasin = mapArray($basin);

            $mappedNeighbours = mapArray($neighbours);

            // Ensure neighbours have not been added to basin before
            $neighboursChecked = array_diff($mappedNeighbours, $mappedBasin);

            // Unmap neighbours
            $neighbours = array_map(function ($neighbour) {
                list($x, $y) = explode(',', $neighbour);
                return [(int) $x, (int) $y];
            }, $neighboursChecked);

            if (count($neighbours) > 0) {
                $basin = calculateBasin($neighbours, $basin);
            }
        }

        return $basin;
    }

    $lowpoints = [];
    $basins = [];
    foreach ($lines as $num => $line) {
        $length = strlen($line);
        for ($x = 0; $x < strlen($line); $x++) {
            $points = retrieveNeighbours($x, $num);

            $totalPoints = array_map(function ($p) use ($lines) {
                return $lines[$p[1]][$p[0]];
            }, $points);

            if (min($totalPoints) > $line[$x]) {
                $lowpoints[] = $line[$x];

                // Basin
                $basins[] = calculateBasin($points, [[$x, $num]]);
            }
        }
    }
    
    $risk = array_map(function ($point) {
        return (int) $point + 1;
    }, $lowpoints);

    $answer1 = array_sum($risk);
    $answer2 = 0;

    $basinSums = [];
    foreach ($basins as $b) {
        $basinSums[] = count($b);
    }

    rsort($basinSums);

    $answer2 = $basinSums[0] * $basinSums[1] * $basinSums[2];

    echo sprintf("Answer 1: %d\nAnswer 2: %d\n", $answer1, $answer2);
