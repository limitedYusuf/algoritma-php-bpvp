<?php

$kriteria = array(
    "kriteria1" => 0.3,
    "kriteria2" => 0.2,
    "kriteria3" => 0.25,
    "kriteria4" => 0.15,
    "kriteria5" => 0.1
);

$alternatif = array(
    "Alternatif A" => array(4, 3, 5, 2, 4),
    "Alternatif B" => array(3, 4, 4, 3, 3),
    "Alternatif C" => array(5, 5, 3, 4, 2)
);

$totalNilai = array();
foreach ($alternatif as $namaAlternatif => $nilaiKriteria) {
    $total = 0;
    $i = 0;
    foreach ($kriteria as $bobot) {
        $total += $nilaiKriteria[$i] * $bobot;
        $i++;
    }
    $totalNilai[$namaAlternatif] = $total;
}

$alternatifTerbaik = array_search(max($totalNilai), $totalNilai);

echo "Hasil Keputusan Penilaian Kesehatan Tanah dengan Metode SAW:<hr>";
echo "Alternatif Terbaik: " . $alternatifTerbaik . "<hr>";
echo "Nilai: " . $totalNilai[$alternatifTerbaik] . "\n";
