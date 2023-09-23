<?php

$tepung = [
    'A' => ['harga' => 10000, 'rasa' => 4, 'tekstur' => 3, 'ketersediaan' => 1, 'nutrisi' => 4],
    'B' => ['harga' => 9000, 'rasa' => 3, 'tekstur' => 4, 'ketersediaan' => 0.5, 'nutrisi' => 4],
];

$bobot = ['harga' => 0.3, 'rasa' => 0.2, 'tekstur' => 0.2, 'ketersediaan' => 0.1, 'nutrisi' => 0.2];

$skorAgregat = [];
foreach ($tepung as $namaTepung => $t) {
    $skor = 0;
    foreach ($t as $kriteria => $nilai) {
        $skor += $nilai * $bobot[$kriteria];
    }
    $skorAgregat[$namaTepung] = $skor;
}

$tePungTerbaik = array_search(max($skorAgregat), $skorAgregat);

echo "Tepung terbaik untuk memproduksi bihun adalah: $tePungTerbaik";
