<?php

$host = 'localhost';
$user = 'root';
$pass = 'root';
$db   = 'saw';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

$sql = "SELECT * FROM kriteria";
$result = $conn->query($sql);

$kriteria = array();
while ($row = $result->fetch_assoc()) {
    $kriteria[$row['id']] = $row['bobot'];
}

$sql = "SELECT * FROM alternatif";
$result = $conn->query($sql);

$alternatif = array();
while ($row = $result->fetch_assoc()) {
    $alternatif[$row['id']] = $row['nama_alternatif'];
}

$totalNilai = array();
foreach ($alternatif as $idAlternatif => $namaAlternatif) {
    $total = 0;
    foreach ($kriteria as $idKriteria => $bobot) {
        $sql = "SELECT nilai FROM nilai_kriteria WHERE id_alternatif = $idAlternatif AND id_kriteria = $idKriteria";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $nilai = $row['nilai'];
        $total += $nilai * $bobot;
    }
    $totalNilai[$namaAlternatif] = $total;
}

$alternatifTerbaik = array_search(max($totalNilai), $totalNilai);

echo "Hasil Keputusan Penilaian Kesehatan Tanah dengan Metode SAW:\n";
echo "Alternatif Terbaik: " . $alternatifTerbaik . "\n";
echo "Nilai: " . $totalNilai[$alternatifTerbaik] . "\n";

$conn->close();
