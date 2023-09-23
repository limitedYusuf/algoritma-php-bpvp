<?php

class Alternatif {
    public $nama;
    public $kriteria;
    
    public function __construct($nama, $kriteria) {
        $this->nama = $nama;
        $this->kriteria = $kriteria;
    }
    
    public function hitungNilaiAgregat($bobotKriteria) {
        $nilaiAgregat = 0;
        foreach ($this->kriteria as $index => $nilai) {
            $nilaiAgregat += $nilai * $bobotKriteria[$index];
        }
        return $nilaiAgregat;
    }
}

class WASPAS {
    public $alternatif = array();
    public $bobotKriteria = array();
    
    public function tambahAlternatif($alternatif) {
        $this->alternatif[] = $alternatif;
    }
    
    public function setBobotKriteria($bobotKriteria) {
        $this->bobotKriteria = $bobotKriteria;
    }
    
    public function evaluasi() {
        $hasilEvaluasi = array();
        foreach ($this->alternatif as $alternatif) {
            $hasilEvaluasi[] = array(
                'nama' => $alternatif->nama,
                'nilai_agregat' => $alternatif->hitungNilaiAgregat($this->bobotKriteria),
            );
        }
        return $hasilEvaluasi;
    }
    
    public function alternatifTerbaik($hasilEvaluasi) {
        $alternatifTerbaik = null;
        $nilaiMax = null;
        foreach ($hasilEvaluasi as $hasil) {
            if ($alternatifTerbaik === null || $hasil['nilai_agregat'] > $nilaiMax) {
                $alternatifTerbaik = $hasil['nama'];
                $nilaiMax = $hasil['nilai_agregat'];
            }
        }
        return $alternatifTerbaik;
    }
}

// Contoh penggunaan
$bobotKriteria = [0.4, 0.3, 0.3];

$alternatif1 = new Alternatif('Alternatif 1', [4, 2, 5]);
$alternatif2 = new Alternatif('Alternatif 2', [5, 3, 4]);
$alternatif3 = new Alternatif('Alternatif 3', [3, 5, 2]);

$waspas = new WASPAS();
$waspas->tambahAlternatif($alternatif1);
$waspas->tambahAlternatif($alternatif2);
$waspas->tambahAlternatif($alternatif3);
$waspas->setBobotKriteria($bobotKriteria);

$hasilEvaluasi = $waspas->evaluasi();
$alternatifTerbaik = $waspas->alternatifTerbaik($hasilEvaluasi);

echo "Hasil Evaluasi:<hr>";
foreach ($hasilEvaluasi as $hasil) {
    echo "Alternatif {$hasil['nama']}: Nilai Agregat = {$hasil['nilai_agregat']}<hr>";
}

echo "Alternatif Terbaik adalah $alternatifTerbaik\n";
