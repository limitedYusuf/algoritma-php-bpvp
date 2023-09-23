<?php

// Matriks dummy
$pairwiseComparisonMatrix = [
    [1, 3, 2, 2],
    [1/3, 1, 1/2, 2/3],
    [1/2, 2, 1, 3/2],
    [1/2, 3/2, 2/3, 1],
];

// Total kriteria
$numCriteria = count($pairwiseComparisonMatrix);

// Step 1: Normalisasi matriks perbandingan berpasangan
$normalizedMatrix = [];
for ($i = 0; $i < $numCriteria; $i++) {
    for ($j = 0; $j < $numCriteria; $j++) {
        $sum = 0;
        for ($k = 0; $k < $numCriteria; $k++) {
            $sum += $pairwiseComparisonMatrix[$k][$j];
        }
        $normalizedMatrix[$i][$j] = $pairwiseComparisonMatrix[$i][$j] / $sum;
    }
}

// Step 2: Menghitung bobot relatif
$weights = [];
for ($i = 0; $i < $numCriteria; $i++) {
    $weights[$i] = array_sum($normalizedMatrix[$i]) / $numCriteria;
}

// Langkah 3: Menghitung nilai konsistensi
$lambdaMax = 0;
for ($i = 0; $i < $numCriteria; $i++) {
    $sum = 0;
    for ($j = 0; $j < $numCriteria; $j++) {
        $sum += $normalizedMatrix[$i][$j] * $weights[$j];
    }
    $lambdaMax += $sum / $weights[$i];
}

$consistencyIndex = ($lambdaMax - $numCriteria) / ($numCriteria - 1);
$consistencyRatio = $consistencyIndex / 0.58;

if ($consistencyRatio <= 0.1) {
    echo "Konsistensi Terpenuhi. Bobot Kriteria: <hr>";
    print_r($weights);

    // dummy saje
    $alternatives = [
        [
            'name' => 'A1',
            'price' => 5000000,
            'camera_quality' => 3,
            'battery_capacity' => 4000,
            'screen_size' => 6,
        ],
        [
            'name' => 'A2',
            'price' => 4500000,
            'camera_quality' => 2,
            'battery_capacity' => 3500,
            'screen_size' => 5.5,
        ],
        [
            'name' => 'A3',
            'price' => 6000000,
            'camera_quality' => 4,
            'battery_capacity' => 4500,
            'screen_size' => 6.5,
        ],
    ];

    // punya alternatif?
    if (count($alternatives) > 0) {
        // Step 4: Menghitung Solusi Ideal Positif (PIS) dan Solusi Ideal Negatif (NIS)
        $idealPositive = [];
        $idealNegative = [];

        foreach ($alternatives as $alternative) {
            $pis = [];
            $nis = [];
            for ($i = 0; $i < $numCriteria; $i++) {
                $criteriaValues = array_column($alternatives, $i);
                if (!empty($criteriaValues)) {
                    $pis[] = max($criteriaValues);
                    $nis[] = min($criteriaValues);
                }
            }
            $idealPositive[] = $pis;
            $idealNegative[] = $nis;
        }

        // Step 5: Menghitung Jarak antara alternatif dengan PIS dan NIS
        $distanceToPositive = [];
        $distanceToNegative = [];

        foreach ($alternatives as $key => $alternative) {
            $positiveSum = 0;
            $negativeSum = 0;
            for ($i = 0; $i < $numCriteria; $i++) {
                $criteriaValues = array_column($alternatives, $i);
                if (!empty($criteriaValues)) {
                    $positiveSum += pow($alternative[$i] - $idealPositive[$key][$i], 2);
                    $negativeSum += pow($alternative[$i] - $idealNegative[$key][$i], 2);
                }
            }
            $distanceToPositive[] = sqrt($positiveSum) ?: 1;
            $distanceToNegative[] = sqrt($negativeSum) ?: 1;
        }

        // Step 6: Menghitung nilai Preferabilitas
        $preferability = [];
        for ($i = 0; $i < count($alternatives); $i++) {
            $preferability[] = $distanceToNegative[$i] / ($distanceToNegative[$i] + $distanceToPositive[$i]);
        }

        echo "<hr>Hasil Preferabilitas untuk Smartphone:<hr>";
        for ($i = 0; $i < count($alternatives); $i++) {
            echo "Alternatif {$alternatives[$i]['name']}: {$preferability[$i]}\n";
        }
    } else {
        echo "Tidak ada alternatif yang tersedia.";
    }
} else {
    echo "Konsistensi Tidak Terpenuhi. Periksa Matriks Perbandingan Berpasangan.";
}
