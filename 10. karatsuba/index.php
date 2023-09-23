<?php
function karatsuba($x, $y)
{
   $strX = (string) $x;
   $strY = (string) $y;

   $lenX = strlen($strX);
   $lenY = strlen($strY);

   if ($lenX == 1 || $lenY == 1) {
      return $x * $y;
   }

   $n = max($lenX, $lenY);
   $m = floor($n / 2);

   $xL = (int) substr($strX, 0, $m);
   $xR = (int) substr($strX, $m);
   $yL = (int) substr($strY, 0, $m);
   $yR = (int) substr($strY, $m);

   $z0 = karatsuba($xR, $yR);
   $z1 = karatsuba($xL + $xR, $yL + $yR);
   $z2 = karatsuba($xL, $yL);

   $result = ($z2 * pow(10, 2 * $m)) + (($z1 - $z2 - $z0) * pow(10, $m)) + $z0;

   return $result;
}

$x = 1234;
$y = 5678;

$result = karatsuba($x, $y);
echo "Hasil perkalian: $result\n";

?>