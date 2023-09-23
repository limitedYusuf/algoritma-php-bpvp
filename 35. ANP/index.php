<?php

$suppliers = array(
    'Supplier A' => array('Harga' => 0.4, 'Kualitas' => 0.3, 'Waktu Pengiriman' => 0.3),
    'Supplier B' => array('Harga' => 0.2, 'Kualitas' => 0.4, 'Waktu Pengiriman' => 0.4),
    'Supplier C' => array('Harga' => 0.5, 'Kualitas' => 0.2, 'Waktu Pengiriman' => 0.2),
);

$kriteria = array(
    'Harga' => array('Supplier A' => 0.4, 'Supplier B' => 0.2, 'Supplier C' => 0.5),
    'Kualitas' => array('Supplier A' => 0.3, 'Supplier B' => 0.4, 'Supplier C' => 0.2),
    'Waktu Pengiriman' => array('Supplier A' => 0.3, 'Supplier B' => 0.4, 'Supplier C' => 0.2),
);

$jumlah_kriteria = count($kriteria);
$jumlah_supplier = count($suppliers);

foreach ($kriteria as $k => $v) {
    $total_bobot_kriteria[$k] = array_sum($v);
    $bobot_kriteria[$k] = $total_bobot_kriteria[$k] / $jumlah_supplier;
}

foreach ($suppliers as $supplier => $kriteria_supplier) {
    foreach ($kriteria_supplier as $k => $v) {
        $bobot_supplier[$supplier][$k] = $v / $total_bobot_kriteria[$k];
    }
}

$peringkat_supplier = array();
foreach ($suppliers as $supplier => $kriteria_supplier) {
    $nilai_akhir = 0;
    foreach ($kriteria_supplier as $k => $v) {
        $nilai_akhir += $bobot_supplier[$supplier][$k] * $bobot_kriteria[$k];
    }
    $peringkat_supplier[$supplier] = $nilai_akhir;
}

arsort($peringkat_supplier);
$supplier_terbaik = key($peringkat_supplier);

echo "Hasil Pemilihan Supplier Bahan Baku Benang:<hr>";
echo "Supplier Terbaik: $supplier_terbaik<hr>";
echo "Peringkat Supplier:<hr>";
foreach ($peringkat_supplier as $supplier => $peringkat) {
    echo "$supplier: $peringkat<hr>";
}
