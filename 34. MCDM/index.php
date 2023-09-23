<?php

$kriteria = array("Biaya", "Pengurangan Emisi CO2", "Keandalan Pasokan Energi");
$alternatif = array("Alternatif A", "Alternatif B", "Alternatif C");

$bobot_kriteria = array(60, 30, 10);

$nilai_alternatif = array(
    array(70, 80, 90),
    array(60, 70, 80),
    array(80, 90, 75)
);

function hitungPreferensi($nilai_alternatif, $bobot_kriteria) {
    $jumlah_alternatif = count($nilai_alternatif);
    $preferensi = array();

    for ($i = 0; $i < $jumlah_alternatif; $i++) {
        $total_preferensi = 0;
        for ($j = 0; $j < $jumlah_alternatif; $j++) {
            if ($i != $j) {
                $d_plus = 0;
                $d_minus = 0;
                for ($k = 0; $k < count($bobot_kriteria); $k++) {
                    $d_plus += max(0, $nilai_alternatif[$i][$k] - $nilai_alternatif[$j][$k]) * $bobot_kriteria[$k];
                    $d_minus += max(0, $nilai_alternatif[$j][$k] - $nilai_alternatif[$i][$k]) * $bobot_kriteria[$k];
                }
                $preferensi[$i][$j] = $d_plus - $d_minus;
                $total_preferensi += $preferensi[$i][$j];
            }
        }
        $preferensi[$i]['total'] = $total_preferensi;
    }

    return $preferensi;
}

function rangkingAlternatif($preferensi) {
    $peringkat = array();

    foreach ($preferensi as $index => $data) {
        $peringkat[$index] = $data['total'];
    }

    arsort($peringkat);

    return array_keys($peringkat);
}

$preferensi_alternatif = hitungPreferensi($nilai_alternatif, $bobot_kriteria);

$peringkat = rangkingAlternatif($preferensi_alternatif);

echo "Hasil Audit Energi menggunakan Metode MCDM-PROMETHEE:<hr>";
foreach ($peringkat as $index) {
    echo $alternatif[$index] . ": " . $preferensi_alternatif[$index]['total'] . "<hr>";
}
