<?php

$dosens = [
    [
        'id' => 1,
        'nama' => 'Dosen A',
        'IPK' => 3.5,
        'topik_skripsi' => 'Machine Learning',
        'bidang_minat' => 'AI',
        'kapasitas_pembimbing' => 2,
    ],
    [
        'id' => 2,
        'nama' => 'Dosen B',
        'IPK' => 3.2,
        'topik_skripsi' => 'Data Science',
        'bidang_minat' => 'AI',
        'kapasitas_pembimbing' => 1,
    ],
];

$mahasiswa = [
    [
        'id' => 101,
        'nama' => 'Mahasiswa X',
        'IPK' => 3.6,
        'topik_skripsi' => 'Machine Learning',
        'bidang_minat' => 'AI',
    ],
    [
        'id' => 102,
        'nama' => 'Mahasiswa Y',
        'IPK' => 3.3,
        'topik_skripsi' => 'Data Science',
        'bidang_minat' => 'AI',
    ],
];

function euclideanDistance($mahasiswa, $dosen) {
    $distance = sqrt(
        pow(floatval($mahasiswa['IPK']) - floatval($dosen['IPK']), 2) +
        pow(floatval($mahasiswa['topik_skripsi']) - floatval($dosen['topik_skripsi']), 2) +
        pow(floatval($mahasiswa['bidang_minat']) - floatval($dosen['bidang_minat']), 2)
    );
    return $distance;
}

$hasilPemilihan = [];
foreach ($mahasiswa as $mhs) {
    $dosenTerpilih = null;
    $jarakTerpendek = PHP_FLOAT_MAX;

    foreach ($dosens as $dosen) {
        $jarak = euclideanDistance($mhs, $dosen);

        if ($jarak < $jarakTerpendek && $dosen['kapasitas_pembimbing'] > 0) {
            $dosenTerpilih = $dosen;
            $jarakTerpendek = $jarak;
        }
    }

    if ($dosenTerpilih !== null) {
        $key = array_search($dosenTerpilih, $dosens);
        if ($key !== false) {
            $dosens[$key]['kapasitas_pembimbing']--;
        }
        $hasilPemilihan[] = [
            'mahasiswa' => $mhs['nama'],
            'dosen_pembimbing' => $dosenTerpilih['nama'],
        ];
    }
}

foreach ($hasilPemilihan as $hasil) {
    echo "Mahasiswa: {$hasil['mahasiswa']} -> Dosen Pembimbing: {$hasil['dosen_pembimbing']}<hr>";
}
