<?php

function greedyDiet($nutrients, $foods, $requirements)
{
   $solution = array();
   $remainingRequirements = $requirements;

   usort($foods, function ($a, $b) {
      $costPerNutritionA = $a['cost'] / array_sum($a['nutrition']);
      $costPerNutritionB = $b['cost'] / array_sum($b['nutrition']);

      if ($costPerNutritionA == $costPerNutritionB) {
         return 0;
      }
      return ($costPerNutritionA < $costPerNutritionB) ? -1 : 1;
   });

   foreach ($foods as $food) {
      $foodName = $food['name'];

      if (isFulfilling($food, $remainingRequirements, $nutrients)) {
         $solution[$foodName] = 1;
         deductRequirements($food, $remainingRequirements);
      }
   }

   return $solution;
}

function isFulfilling($food, $requirements) {
    foreach ($food['nutrition'] as $nutrient => $amount) {
        if ($amount > $requirements[$nutrient]) {
            return false;
        }
    }
    return true;
}

function deductRequirements($food, &$requirements) {
    foreach ($food['nutrition'] as $nutrient => $amount) {
        $requirements[$nutrient] -= $amount;
    }
}

$nutrients = [
    'protein' => 50,
    'carbs' => 200,
    'fat' => 30,
];

$foods = [
    ['name' => 'Food A', 'cost' => 10, 'nutrition' => ['protein' => 5, 'carbs' => 20, 'fat' => 3]],
    ['name' => 'Food B', 'cost' => 15, 'nutrition' => ['protein' => 7, 'carbs' => 30, 'fat' => 4]],
    ['name' => 'Food C', 'cost' => 8, 'nutrition' => ['protein' => 3, 'carbs' => 15, 'fat' => 2]],
];

$requirements = $nutrients;
$solution = greedyDiet($nutrients, $foods, $requirements);

echo "Solusi Diet:<hr>";
foreach ($solution as $foodName => $amount) {
    echo "$foodName: $amount<hr>";
}
