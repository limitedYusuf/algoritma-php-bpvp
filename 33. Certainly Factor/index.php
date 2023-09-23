<?php

$gejala = array(
   "G1" => "Mual",
   "G2" => "Muntah",
   "G3" => "Diare",
   "G4" => "Perut Kembung",
   "G5" => "Nyeri Perut",
);

$penyakit = array(
   "P1" => "Gastritis",
   "P2" => "Usus Buntu",
   "P3" => "Sembelit",
);

$aturan = array(
   array("G1", "P1", 0.7), // Jika mual, kemungkinan Gastritis adalah 70%
   array("G2", "P1", 0.6), // Jika muntah, kemungkinan Gastritis adalah 60%
   array("G3", "P1", 0.4), // Jika diare, kemungkinan Gastritis adalah 40%
   array("G4", "P1", 0.3), // Jika perut kembung, kemungkinan Gastritis adalah 30%
   array("G5", "P1", 0.5), // Jika nyeri perut, kemungkinan Gastritis adalah 50%
   array("G1", "P2", 0.2), // Jika mual, kemungkinan Usus Buntu adalah 20%
   array("G2", "P2", 0.8), // Jika muntah, kemungkinan Usus Buntu adalah 80%
   array("G4", "P2", 0.5), // Jika perut kembung, kemungkinan Usus Buntu adalah 50%
   array("G1", "P3", 0.4), // Jika mual, kemungkinan Sembelit adalah 40%
   array("G3", "P3", 0.7), // Jika diare, kemungkinan Sembelit adalah 70%
   array("G5", "P3", 0.3), // Jika nyeri perut, kemungkinan Sembelit adalah 30%
);

function getGejalaOptions($gejala)
{
   $options = "";
   foreach ($gejala as $kode => $nama) {
      $options .= "<option value='$kode'>$nama</option>";
   }
   return $options;
}

function diagnosisPenyakit($user_input, $aturan)
{
   $cf_values = array();

   foreach ($aturan as $rule) {
      list($gejala_rule, $penyakit_rule, $cf_rule) = $rule;

      if (in_array($gejala_rule, $user_input)) {
         if (!isset($cf_values[$penyakit_rule])) {
            $cf_values[$penyakit_rule] = 0;
         }
         $cf_values[$penyakit_rule] += $cf_rule * (1 - $cf_values[$penyakit_rule]);
      }
   }

   arsort($cf_values);
   return $cf_values;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
   $selected_gejala = $_POST["gejala"];
   $diagnosis = diagnosisPenyakit($selected_gejala, $aturan);
}

?>

<!DOCTYPE html>
<html>

<head>
   <title>Diagnosis Penyakit Pencernaan</title>
</head>

<body>
   <h1>Diagnosis Penyakit Pencernaan</h1>
   <form method="POST">
      <label>Pilih Gejala yang Anda Alami:</label><br>
      <select name="gejala[]" multiple>
         <?= getGejalaOptions($gejala); ?>
      </select><br><br>
      <input type="submit" value="Diagnosis">
   </form>
   <?php
   if (isset($diagnosis) && !empty($diagnosis)) {
      echo "<h2>Hasil Diagnosis:</h2>";
      foreach ($diagnosis as $penyakit => $cf) {
         echo "Kemungkinan Anda menderita $penyakit dengan CF = $cf<br>";
      }
   }
   ?>
</body>

</html>