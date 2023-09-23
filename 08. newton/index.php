<?php
function newtonRaphson($initialGuess, $tolerance, $maxIterations)
{
   $x = $initialGuess;
   $iteration = 0;

   do {
      $fx = $x * $x - 5;
      $dfx = 2 * $x;

      $deltaX = $fx / $dfx;

      $x = $x - $deltaX;

      $iteration++;

      if (abs($deltaX) < $tolerance || $iteration >= $maxIterations) {
         break;
      }
   } while (true);

   return $x;
}

$initialGuess = 2.0;
$tolerance = 1e-6;
$maxIterations = 100;

$root = newtonRaphson($initialGuess, $tolerance, $maxIterations);

echo "Akar fungsi: $root\n";

?>