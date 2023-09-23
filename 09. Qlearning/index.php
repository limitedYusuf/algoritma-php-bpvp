<?php
class QLearning
{
   private $qTable;
   private $learningRate;
   private $discountFactor;
   private $explorationRate;

   public function __construct($numStates, $numActions, $learningRate, $discountFactor, $explorationRate)
   {
      $this->qTable = array_fill(0, $numStates, array_fill(0, $numActions, 0));
      $this->learningRate = $learningRate;
      $this->discountFactor = $discountFactor;
      $this->explorationRate = $explorationRate;
   }

   public function selectAction($state)
   {
      if (mt_rand(0, 1) < $this->explorationRate) {
         return mt_rand(0, count($this->qTable[$state]) - 1);
      } else {
         return array_search(max($this->qTable[$state]), $this->qTable[$state]);
      }
   }

   public function updateQValue($state, $action, $reward, $nextState)
   {
      $currentQValue = $this->qTable[$state][$action];
      $maxNextQValue = max($this->qTable[$nextState]);

      $newQValue = $currentQValue + $this->learningRate * ($reward + $this->discountFactor * $maxNextQValue - $currentQValue);
      $this->qTable[$state][$action] = $newQValue;
   }

   public function getQTable()
   {
      return $this->qTable;
   }
}

$numStates = 6;
$numActions = 2;

$learningRate = 0.1;
$discountFactor = 0.9;
$explorationRate = 0.2;

$qLearning = new QLearning($numStates, $numActions, $learningRate, $discountFactor, $explorationRate);

for ($episode = 0; $episode < 1000; $episode++) {
   $currentState = mt_rand(0, $numStates - 1);

   while ($currentState != 5) {
      $action = $qLearning->selectAction($currentState);
      $nextState = ($action == 0) ? max($currentState - 1, 0) : min($currentState + 1, $numStates - 1);
      $reward = ($nextState == 5) ? 1 : 0;
      $qLearning->updateQValue($currentState, $action, $reward, $nextState);
      $currentState = $nextState;
   }
}

// Hasil pembelajaran
$qTable = $qLearning->getQTable();
print_r($qTable);

?>