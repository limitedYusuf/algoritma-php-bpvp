<?php
function bubbleSort($arr, $ascending = true) {
    $n = count($arr);
    for ($i = 0; $i < $n - 1; $i++) {
        for ($j = 0; $j < $n - $i - 1; $j++) {
            if ($ascending) {
                if ($arr[$j] > $arr[$j + 1]) {
                    $temp = $arr[$j];
                    $arr[$j] = $arr[$j + 1];
                    $arr[$j + 1] = $temp;
                }
            } else {
                if ($arr[$j] < $arr[$j + 1]) {
                    $temp = $arr[$j];
                    $arr[$j] = $arr[$j + 1];
                    $arr[$j + 1] = $temp;
                }
            }
        }
    }
    return $arr;
}

$arr = [64, 25, 12, 22, 11];

$sortedArrAscending = bubbleSort($arr);
print_r($sortedArrAscending);

echo "<hr>";

$sortedArrDescending = bubbleSort($arr, false);
print_r($sortedArrDescending);
