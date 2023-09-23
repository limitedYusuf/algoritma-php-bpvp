<?php
function fibonacci($n)
{
   $fib = [];

   $fib[0] = 0;
   $fib[1] = 1;

   for ($i = 2; $i <= $n; $i++) {
      $fib[$i] = $fib[$i - 1] + $fib[$i - 2];
   }

   return $fib[$n];
}

$n = 10;
$result = fibonacci($n);
echo "Nilai Fibonacci ke-$n adalah: $result\n";

?>