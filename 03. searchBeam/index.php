<?php
function beamSearch($goal, $beamWidth, $maxIterations)
{
    $currentSolutions = [rand(1, 100)];
    
    for ($iteration = 1; $iteration <= $maxIterations; $iteration++) {
        $nextSolutions = [];

        foreach ($currentSolutions as $currentSolution) {
            for ($i = -1; $i <= 1; $i++) {
                $candidate = $currentSolution + $i;
                if ($candidate >= 1 && $candidate <= 100) {
                    $nextSolutions[] = $candidate;
                }
            }
        }

        usort($nextSolutions, function($a, $b) use ($goal) {
            return abs($a - $goal) <=> abs($b - $goal);
        });

        $currentSolutions = array_slice($nextSolutions, 0, $beamWidth);

        echo "Iteration $iteration: " . implode(', ', $currentSolutions) . "<hr>";

        if (in_array($goal, $currentSolutions)) {
            echo "Solusi ditemukan: $goal<hr>";
            return $goal;
        }
    }

    echo "Solusi tidak ditemukan<hr>";
    return null;
}

$goal = 42;
$beamWidth = 5;
$maxIterations = 10;

echo "Pencarian Beam untuk mencari $goal<hr>";
beamSearch($goal, $beamWidth, $maxIterations);
