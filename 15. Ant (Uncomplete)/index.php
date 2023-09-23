<?php

class Ant
{
    private $pheromoneMatrix;
    private $distanceMatrix;
    private $numNodes;
    private $alpha;
    private $beta;

    private $path;
    private $visited;
    private $distance;

    public function __construct($pheromoneMatrix, $distanceMatrix, $alpha, $beta)
    {
        $this->pheromoneMatrix = $pheromoneMatrix;
        $this->distanceMatrix = $distanceMatrix;
        $this->numNodes = count($pheromoneMatrix);
        $this->alpha = $alpha;
        $this->beta = $beta;

        $this->path = [];
        $this->visited = array_fill(0, $this->numNodes, false);
        $this->distance = 0;
    }

    public function findPath($startNode)
    {
        $this->path = [$startNode];
        $this->visited[$startNode] = true;

        for ($i = 1; $i < $this->numNodes; $i++) {
            $nextNode = $this->selectNextNode();
            $this->path[] = $nextNode;
            $this->visited[$nextNode] = true;
            $this->distance += $this->distanceMatrix[$this->path[$i - 1]][$nextNode];
        }

        // Kembali ke titik awal
        $this->path[] = $startNode;
        $this->distance += $this->distanceMatrix[$this->path[$this->numNodes - 1]][$startNode];
    }

   private function selectNextNode()
   {
      $currentNode = end($this->path);
      $sum = 0;
      $probabilities = [];

      for ($i = 0; $i < $this->numNodes; $i++) {
         if (!$this->visited[$i]) {
            $pheromone = $this->pheromoneMatrix[$currentNode][$i];
            $distance = $this->distanceMatrix[$currentNode][$i];

            if ($pheromone == 0 || $distance == 0) {
               $probabilities[$i] = 0;
            } else {
               $probabilities[$i] = pow($pheromone, $this->alpha) * pow(1 / $distance, $this->beta);
               $sum += $probabilities[$i];
            }
         }
      }

      if ($sum == 0) {
         $unvisitedNodes = array_keys($this->visited, false);
         $node = $unvisitedNodes[array_rand($unvisitedNodes)];
      } else {
         $randomValue = mt_rand() / mt_getrandmax() * $sum;
         $cumulativeProbability = 0;

         for ($i = 0; $i < $this->numNodes; $i++) {
            if (!$this->visited[$i]) {
               $cumulativeProbability += $probabilities[$i] / $sum;
               if ($randomValue <= $cumulativeProbability) {
                  $node = $i;
                  break;
               }
            }
         }
      }

      return $node;
   }

    public function getPath()
    {
        return $this->path;
    }

    public function getDistance()
    {
        return $this->distance;
    }
}

class AntColonyOptimization
{
    private $pheromoneMatrix;
    private $distanceMatrix;
    private $numAnts;
    private $numNodes;
    private $alpha;
    private $beta;
    private $evaporationRate;
    private $Q;

    private $ants;

    public function __construct($numAnts, $numNodes, $alpha, $beta, $evaporationRate, $Q)
    {
        $this->numAnts = $numAnts;
        $this->numNodes = $numNodes;
        $this->alpha = $alpha;
        $this->beta = $beta;
        $this->evaporationRate = $evaporationRate;
        $this->Q = $Q;

        $this->distanceMatrix = [
            [0, 1, 2, 3],
            [1, 0, 4, 5],
            [2, 4, 0, 6],
            [3, 5, 6, 0]
        ];

        $this->pheromoneMatrix = array_fill(0, $numNodes, array_fill(0, $numNodes, 1));

        $this->ants = [];
        for ($i = 0; $i < $numAnts; $i++) {
            $ant = new Ant($this->pheromoneMatrix, $this->distanceMatrix, $alpha, $beta);
            $this->ants[] = $ant;
        }
    }

    public function runACO($numIterations)
    {
      for ($iteration = 0; $iteration < $numIterations; $iteration++) {
         foreach ($this->ants as $ant) {
            $startNode = mt_rand(0, $this->numNodes - 1);
            $ant->findPath($startNode);
         }

         $this->updatePheromone();
         $this->evaporatePheromone();
      }
    }

    private function updatePheromone()
    {
        $rho = $this->evaporationRate;

        foreach ($this->ants as $ant) {
            $antPath = $ant->getPath();
            $antDistance = $ant->getDistance();

            for ($i = 0; $i < $this->numNodes - 1; $i++) {
                $fromNode = $antPath[$i];
                $toNode = $antPath[$i + 1];
                $this->pheromoneMatrix[$fromNode][$toNode] += $this->Q / $antDistance;
                $this->pheromoneMatrix[$toNode][$fromNode] += $this->Q / $antDistance;
            }
        }
    }

    private function evaporatePheromone()
    {
        $rho = $this->evaporationRate;

        for ($i = 0; $i < $this->numNodes; $i++) {
            for ($j = 0; $j < $this->numNodes; $j++) {
                $this->pheromoneMatrix[$i][$j] *= (1 - $rho);
            }
        }
    }

    public function getBestPath()
    {
        $bestPath = [];
        $bestDistance = PHP_INT_MAX;

        foreach ($this->ants as $ant) {
            $antDistance = $ant->getDistance();
            if ($antDistance < $bestDistance) {
                $bestDistance = $antDistance;
                $bestPath = $ant->getPath();
            }
        }

        return $bestPath;
    }
}

$numAnts = 10;
$numNodes = 4;
$alpha = 1.0;
$beta = 2.0;
$evaporationRate = 0.5;
$Q = 1.0;

$aco = new AntColonyOptimization($numAnts, $numNodes, $alpha, $beta, $evaporationRate, $Q);
$numIterations = 1;
$aco->runACO($numIterations);
$bestPath = $aco->getBestPath();
echo "Jalur terpendek: " . implode(" -> ", $bestPath) . "\n";
