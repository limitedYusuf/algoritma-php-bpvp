<?php
function generatePopulation($populationSize, $geneLength) {
    $population = [];

    for ($i = 0; $i < $populationSize; $i++) {
        $individual = '';
        for ($j = 0; $j < $geneLength; $j++) {
            $individual .= chr(rand(32, 126));
        }
        $population[] = $individual;
    }

    return $population;
}

function calculateFitness($population, $target) {
    $fitnessScores = [];

    foreach ($population as $individual) {
        $fitness = 0;
        for ($i = 0; $i < strlen($individual); $i++) {
            if ($individual[$i] == $target[$i]) {
                $fitness++;
            }
        }
        $fitnessScores[] = $fitness;
    }

    return $fitnessScores;
}

function selectParents($population, $fitnessScores) {
    $parents = [];

    for ($i = 0; $i < count($population); $i++) {
        $parent1 = $population[array_search(max($fitnessScores), $fitnessScores)];
        $fitnessScores[array_search(max($fitnessScores), $fitnessScores)] = -1;
        $parent2 = $population[array_search(max($fitnessScores), $fitnessScores)];
        $parents[] = [$parent1, $parent2];
    }

    return $parents;
}

function crossover($parents) {
    $offspring = [];

    foreach ($parents as $pair) {
        $parent1 = $pair[0];
        $parent2 = $pair[1];
        $midpoint = rand(1, strlen($parent1) - 1);
        $child1 = substr($parent1, 0, $midpoint) . substr($parent2, $midpoint);
        $child2 = substr($parent2, 0, $midpoint) . substr($parent1, $midpoint);
        $offspring[] = $child1;
        $offspring[] = $child2;
    }

    return $offspring;
}

function mutate($population, $mutationRate) {
    foreach ($population as &$individual) {
        for ($i = 0; $i < strlen($individual); $i++) {
            if (rand(0, 100) < $mutationRate) {
                $individual[$i] = chr(rand(32, 126));
            }
        }
    }

    return $population;
}

function isSolutionFound($population, $target) {
    foreach ($population as $individual) {
        if ($individual === $target) {
            return true;
        }
    }
    return false;
}

$targetString = "Hello, World!";
$populationSize = 100;
$mutationRate = 1;

$population = generatePopulation($populationSize, strlen($targetString));

$generation = 0;
$maxGenerations = 1000;
while (!isSolutionFound($population, $targetString) && $generation < $maxGenerations) {
    $fitnessScores = calculateFitness($population, $targetString);
    $parents = selectParents($population, $fitnessScores);
    $population = crossover($parents);
    $population = mutate($population, $mutationRate);
    $generation++;

    echo "Generasi $generation: " . implode(", ", $population) . "\n";
}

if (isSolutionFound($population, $targetString)) {
    echo "Solusi ditemukan pada generasi $generation: " . implode(", ", $population) . "\n";
} else {
    echo "Solusi tidak ditemukan dalam $maxGenerations generasi.\n";
}
