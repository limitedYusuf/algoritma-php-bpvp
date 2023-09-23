<?php
class Item
{
   public $weight;
   public $value;
   public $ratio;
   public $included;

   public function __construct($weight, $value)
   {
      $this->weight = $weight;
      $this->value = $value;
      $this->ratio = $value / $weight;
      $this->included = false;
   }
}

function knapsackBranchAndBound($items, $capacity)
{
   usort($items, function ($a, $b) {
      return $b->ratio <=> $a->ratio;
   });

   $n = count($items);
   $bestValue = 0;
   $currentValue = 0;
   $currentWeight = 0;
   $bestCombination = [];

   function bound($i, $currentValue, $currentWeight, $items, $capacity, $bestValue)
   {
      $bound = $currentValue;
      $remainingWeight = $capacity - $currentWeight;

      while ($i < count($items) && $remainingWeight >= $items[$i]->weight) {
         $bound += $items[$i]->value;
         $remainingWeight -= $items[$i]->weight;
         $i++;
      }

      if ($i < count($items)) {
         $bound += $items[$i]->ratio * $remainingWeight;
      }

      return $bound > $bestValue;
   }

   function knapsack($i, $currentValue, $currentWeight, $combination, $items, $capacity, &$bestValue, &$bestCombination)
   {
      if ($currentWeight <= $capacity && $currentValue > $bestValue) {
         $bestValue = $currentValue;
         $bestCombination = $combination;
      }

      if ($i >= count($items) || !bound($i, $currentValue, $currentWeight, $items, $capacity, $bestValue)) {
         return;
      }

      $newCombination = $combination;
      $newCombination[] = $items[$i];
      knapsack($i + 1, $currentValue + $items[$i]->value, $currentWeight + $items[$i]->weight, $newCombination, $items, $capacity, $bestValue, $bestCombination);
      knapsack($i + 1, $currentValue, $currentWeight, $combination, $items, $capacity, $bestValue, $bestCombination);
   }

   knapsack(0, 0, 0, [], $items, $capacity, $bestValue, $bestCombination);

   return $bestCombination;
}

$items = [
   new Item(2, 10),
   new Item(3, 5),
   new Item(5, 15),
   new Item(7, 7),
   new Item(1, 6)
];

$capacity = 10;

$bestCombination = knapsackBranchAndBound($items, $capacity);

$totalValue = 0;
$totalWeight = 0;
foreach ($bestCombination as $item) {
   $totalValue += $item->value;
   $totalWeight += $item->weight;
}

echo "Items yang dipilih:<hr>";
foreach ($bestCombination as $item) {
   echo "Weight: {$item->weight}, Value: {$item->value}<hr>";
}

echo "Total Value: $totalValue<hr>";
echo "Total Weight: $totalWeight\n";
