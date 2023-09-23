<?php

$dataLatih = array(
    array('sunny', 'hot', 'high', 'no'),
    array('sunny', 'hot', 'high', 'no'),
    array('overcast', 'hot', 'high', 'yes'),
    array('rainy', 'mild', 'high', 'yes'),
    array('rainy', 'cool', 'normal', 'yes'),
    array('rainy', 'cool', 'normal', 'no'),
    array('overcast', 'cool', 'normal', 'yes'),
    array('sunny', 'mild', 'high', 'no'),
    array('sunny', 'cool', 'normal', 'yes'),
    array('rainy', 'mild', 'normal', 'yes'),
);

$labelKelas = array('no', 'no', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'yes', 'yes');

$dataUji = array('sunny', 'cool', 'high');

$kelas = array_unique($labelKelas);
$jumlahKelas = count($kelas);
$jumlahDataLatih = count($dataLatih);

$probabilitasKelas = array();

foreach ($kelas as $kelasItem) {
    $jumlahKelasItem = array_count_values($labelKelas)[$kelasItem];
    $probabilitasKelas[$kelasItem] = $jumlahKelasItem / $jumlahDataLatih;
}

$probabilitasAtribut = array();

foreach ($kelas as $kelasItem) {
    $indeksKelas = array_keys($kelas, $kelasItem)[0];
    $probabilitasAtribut[$kelasItem] = array();
    
    for ($i = 0; $i < count($dataLatih[0]); $i++) {
        $probabilitasAtribut[$kelasItem][$i] = array();
        
        foreach (array_unique(array_column($dataLatih, $i)) as $atribut) {
            $jumlahKemunculanAtribut = 0;
            
            for ($j = 0; $j < $jumlahDataLatih; $j++) {
                if ($dataLatih[$j][$i] == $atribut && $labelKelas[$j] == $kelasItem) {
                    $jumlahKemunculanAtribut++;
                }
            }
            
            $probabilitasAtribut[$kelasItem][$i][$atribut] = ($jumlahKemunculanAtribut + 1) / ($jumlahKelasItem + count(array_unique(array_column($dataLatih, $i))));
        }
    }
}

$probabilitasDataUji = array();

foreach ($kelas as $kelasItem) {
    $probabilitasDataUji[$kelasItem] = $probabilitasKelas[$kelasItem];
    
    for ($i = 0; $i < count($dataUji); $i++) {
        if (isset($probabilitasAtribut[$kelasItem][$i][$dataUji[$i]])) {
            $probabilitasDataUji[$kelasItem] *= $probabilitasAtribut[$kelasItem][$i][$dataUji[$i]];
        } else {
            // Jika atribut tidak ada dalam data pelatihan, gunakan probabilitas nol
            $probabilitasDataUji[$kelasItem] *= 0;
        }
    }
}

$kelasTerklasifikasi = '';

foreach ($probabilitasDataUji as $kelasItem => $probabilitas) {
    if ($kelasTerklasifikasi == '' || $probabilitas > $probabilitasDataUji[$kelasTerklasifikasi]) {
        $kelasTerklasifikasi = $kelasItem;
    }
}

echo "Data uji (" . implode(", ", $dataUji) . ") terklasifikasi sebagai: " . $kelasTerklasifikasi;
