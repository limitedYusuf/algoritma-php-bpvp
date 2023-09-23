<?php
class DifferentialEvolution
{
   private $population;
   private $populationSize;
   private $dimension;
   private $maxGenerations;
   private $mutationFactor;
   private $crossoverRate;
   private $lowerBound;
   private $upperBound;

   public function __construct($populationSize, $dimension, $maxGenerations, $mutationFactor, $crossoverRate, $lowerBound, $upperBound)
   {
      $this->populationSize = $populationSize;
      $this->dimension = $dimension;
      $this->maxGenerations = $maxGenerations;
      $this->mutationFactor = $mutationFactor;
      $this->crossoverRate = $crossoverRate;
      $this->lowerBound = $lowerBound;
      $this->upperBound = $upperBound;
      $this->initializePopulation();
   }

   private function initializePopulation()
   {
      $this->population = [];
      for ($i = 0; $i < $this->populationSize; $i++) {
         $individual = [];
         for ($j = 0; $j < $this->dimension; $j++) {
            $individual[] = rand($this->lowerBound, $this->upperBound);
         }
         $this->population[] = $individual;
      }
   }

   private function clip($value, $min, $max)
   {
      return max(min($value, $max), $min);
   }

   private function mutate($target, $base1, $base2)
   {
      $mutant = [];
      for ($i = 0; $i < $this->dimension; $i++) {
         $mutantValue = $target[$i] + $this->mutationFactor * ($base1[$i] - $base2[$i]);
         $mutant[] = $this->clip($mutantValue, $this->lowerBound, $this->upperBound);
      }
      return $mutant;
   }

   private function crossover($target, $mutant)
   {
      $trial = [];
      for ($i = 0; $i < $this->dimension; $i++) {
         if (mt_rand() / mt_getrandmax() <= $this->crossoverRate) {
            $trial[] = $mutant[$i];
         } else {
            $trial[] = $target[$i];
         }
      }
      return $trial;
   }

   private function fitness($individual)
   {
      // Implementasikan fungsi fitness sesuai dengan masalah yang ingin dipecahkan
      // Fungsi ini akan menghitung nilai fitness untuk individu tertentu
   }

   public function optimize()
   {
      for ($generation = 0; $generation < $this->maxGenerations; $generation++) {
         for ($i = 0; $i < $this->populationSize; $i++) {
            $targetIndex = $i;
            do {
               $base1Index = rand(0, $this->populationSize - 1);
            } while ($base1Index == $targetIndex);

            do {
               $base2Index = rand(0, $this->populationSize - 1);
            } while ($base2Index == $targetIndex || $base2Index == $base1Index);

            $target = $this->population[$targetIndex];
            $base1 = $this->population[$base1Index];
            $base2 = $this->population[$base2Index];

            $mutant = $this->mutate($target, $base1, $base2);
            $trial = $this->crossover($target, $mutant);

            $targetFitness = $this->fitness($target);
            $trialFitness = $this->fitness($trial);

            if ($trialFitness < $targetFitness) {
               $this->population[$targetIndex] = $trial;
            }
         }
      }

      // Cari individu dengan nilai fitness terbaik dalam populasi
      $bestIndividual = $this->population[0];
      $bestFitness = $this->fitness($bestIndividual);

      foreach ($this->population as $individual) {
         $fitness = $this->fitness($individual);
         if ($fitness < $bestFitness) {
            $bestIndividual = $individual;
            $bestFitness = $fitness;
         }
      }

      return $bestIndividual;
   }
}

// Contoh penggunaan
$populationSize = 50;
$dimension = 10;
$maxGenerations = 100;
$mutationFactor = 0.5;
$crossoverRate = 0.7;
$lowerBound = -10;
$upperBound = 10;

$de = new DifferentialEvolution($populationSize, $dimension, $maxGenerations, $mutationFactor, $crossoverRate, $lowerBound, $upperBound);
$bestSolution = $de->optimize();

echo "Solusi Terbaik: ";
print_r($bestSolution);

?>