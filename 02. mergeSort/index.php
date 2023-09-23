<?php
function mergeSort($arr, $ascending = true)
{
    if (count($arr) <= 1) {
        return $arr;
    }

    $mid = count($arr) / 2;
    $left = array_slice($arr, 0, $mid);
    $right = array_slice($arr, $mid);

    $left = mergeSort($left, $ascending);
    $right = mergeSort($right, $ascending);

    return merge($left, $right, $ascending);
}

function merge($left, $right, $ascending)
{
    $result = [];
    $leftIndex = $rightIndex = 0;

    while ($leftIndex < count($left) && $rightIndex < count($right)) {
        if ($ascending) {
            if ($left[$leftIndex] < $right[$rightIndex]) {
                $result[] = $left[$leftIndex];
                $leftIndex++;
            } else {
                $result[] = $right[$rightIndex];
                $rightIndex++;
            }
        } else {
            if ($left[$leftIndex] > $right[$rightIndex]) {
                $result[] = $left[$leftIndex];
                $leftIndex++;
            } else {
                $result[] = $right[$rightIndex];
                $rightIndex++;
            }
        }
    }

    while ($leftIndex < count($left)) {
        $result[] = $left[$leftIndex];
        $leftIndex++;
    }

    while ($rightIndex < count($right)) {
        $result[] = $right[$rightIndex];
        $rightIndex++;
    }

    return $result;
}

$arr = [64, 34, 25, 12, 22, 11, 90];

$sortedArrAscending = mergeSort($arr, true);
print_r($sortedArrAscending);

echo "<hr>";

$sortedArrDescending = mergeSort($arr, false);
print_r($sortedArrDescending);
