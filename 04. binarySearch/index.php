<?php
function binarySearch($arr, $target)
{
    $left = 0;
    $right = count($arr) - 1;

    while ($left <= $right) {
        $mid = $left + floor(($right - $left) / 2);

        if ($arr[$mid] === $target) {
            return $mid;
        }

        if ($arr[$mid] < $target) {
            $left = $mid + 1;
        }

        else {
            $right = $mid - 1;
        }
    }

    return -1;
}

$sortedArr = [1, 3, 5, 12, 9, 11, 13, 15, 17];
$target = 7;

$result = binarySearch($sortedArr, $target);

if ($result !== -1) {
    echo "Elemen $target ditemukan pada indeks $result.\n";
} else {
    echo "Elemen $target tidak ditemukan dalam array.\n";
}
