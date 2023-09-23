<?php
class BatAlgorithm
{
   private $population;
   private $populationSize;
   private $dimension;
   private $maxGenerations;
   private $fmin;
   private $fmax;
   private $alpha;
   private $gamma;

   public function __construct($populationSize, $dimension, $maxGenerations, $fmin, $fmax, $alpha, $gamma)
   {
      $this->populationSize = $populationSize;
      $this->dimension = $dimension;
      $this->maxGenerations = $maxGenerations;
      $this->fmin = $fmin;
      $this->fmax = $fmax;
      $this->alpha = $alpha;
      $this->gamma = $gamma;
      $this->initializePopulation();
   }

   private function initializePopulation()
   {
      $this->population = [];
      for ($i = 0; $i < $this->populationSize; $i++) {
         $bat = [];
         for ($j = 0; $j < $this->dimension; $j++) {
            $bat[] = rand(0, 1);
         }
         $this->population[] = $bat;
      }
   }

   private function clip($value, $min, $max)
   {
      return max(min($value, $max), $min);
   }

   public function run()
   {
      for ($generation = 0; $generation < $this->maxGenerations; $generation++) {
         foreach ($this->population as &$bat) {
            $randomBat = $this->population[array_rand($this->population)];
            for ($i = 0; $i < $this->dimension; $i++) {
               $lompatan = ($randomBat[$i] - $bat[$i]) * $this->alpha;
               $bat[$i] = $this->clip($bat[$i] + $lompatan, 0, 1);
            }

            $randF = $this->fmin + ($this->fmax - $this->fmin) * rand(0, 1);
            if (rand(0, 1) < $this->alpha) {
               $randF = $randF * exp($this->gamma * $generation);
            }

            $randPosition = $this->population[array_rand($this->population)];
            for ($i = 0; $i < $this->dimension; $i++) {
               $lompatan = ($randPosition[$i] - $bat[$i]) * $randF;
               $bat[$i] = $this->clip($bat[$i] + $lompatan, 0, 1);
            }
         }
      }

      $bestFitness = $this->fitness($this->population[0]);
      $bestBat = $this->population[0];
      foreach ($this->population as $bat) {
         $fitness = $this->fitness($bat);
         if ($fitness < $bestFitness) {
            $bestFitness = $fitness;
            $bestBat = $bat;
         }
      }

      return $bestBat;
   }

   private function fitness($bat)
   {
      $sum = array_sum($bat);
      return $sum;
   }
}

$populationSize = 10;
$dimension = 5;
$maxGenerations = 100;
$fmin = 0;
$fmax = 1;
$alpha = 0.9;
$gamma = 0.9;

$batAlgorithm = new BatAlgorithm($populationSize, $dimension, $maxGenerations, $fmin, $fmax, $alpha, $gamma);
$bestSolution = $batAlgorithm->run();

echo "Solusi Terbaik: ";
print_r($bestSolution);

?>