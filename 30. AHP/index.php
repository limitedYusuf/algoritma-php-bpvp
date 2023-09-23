<?php
if(isset($_POST['submit'])) {
   $kriteria = $_POST['kriteria'];
   $subkriteria = $_POST['subkriteria'];
   $bobot = $_POST['bobot'];

   $jumlah_kriteria = count($kriteria);
   $jumlah_subkriteria = array_map('count', $subkriteria);

   for ($i = 0; $i < $jumlah_kriteria; $i++) {
      $total_bobot_kriteria[$i] = array_sum($bobot[$i]);
      for ($j = 0; $j < $jumlah_subkriteria[$i]; $j++) {
         $bobot_normalisasi[$i][$j] = $bobot[$i][$j] / $total_bobot_kriteria[$i];
      }
   }

   for ($i = 0; $i < $jumlah_kriteria; $i++) {
      $eigenvalue_kriteria[$i] = array_sum($bobot_normalisasi[$i]);
      $eigenvector_kriteria[$i] = $eigenvalue_kriteria[$i] / $jumlah_kriteria;
   }

   $total_eigenvector = array_sum($eigenvector_kriteria);
   $prioritas_kriteria = array_map(function ($eig) use ($total_eigenvector) {
      return $eig / $total_eigenvector;
   }, $eigenvector_kriteria);

   echo "<h1>Hasil Prioritas Kriteria</h1>";
   echo "<ul>";
   for ($i = 0; $i < $jumlah_kriteria; $i++) {
      echo "<li>{$kriteria[$i]}: {$prioritas_kriteria[$i]}</li>";
   }
   echo "</ul>";
}
?>

<!DOCTYPE html>
<html>

<head>
   <title>Pemilihan Supplier Rubber Parts</title>
</head>

<body>
   <h1>Pemilihan Supplier Rubber Parts dengan Metode AHP</h1>
   <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
      <h2>Kriteria</h2>
      <input type="text" name="kriteria[]" placeholder="Kriteria 1">
      <input type="text" name="kriteria[]" placeholder="Kriteria 2">
      <h2>Subkriteria</h2>
      <input type="text" name="subkriteria[0][]" placeholder="Subkriteria 1.1">
      <input type="text" name="subkriteria[0][]" placeholder="Subkriteria 1.2">
      <input type="text" name="subkriteria[1][]" placeholder="Subkriteria 2.1">
      <input type="text" name="subkriteria[1][]" placeholder="Subkriteria 2.2">
      <h2>Nilai Bobot</h2>
      <input type="text" name="bobot[0][]" placeholder="Bobot 1.1">
      <input type="text" name="bobot[0][]" placeholder="Bobot 1.2">
      <input type="text" name="bobot[1][]" placeholder="Bobot 2.1">
      <input type="text" name="bobot[1][]" placeholder="Bobot 2.2">

      <button type="submit" name="submit">Hitung Prioritas</button>
   </form>
</body>

</html>