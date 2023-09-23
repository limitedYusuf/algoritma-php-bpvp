<?php
function haversine($lat1, $lon1, $lat2, $lon2) {
    $lat1 = deg2rad($lat1);
    $lon1 = deg2rad($lon1);
    $lat2 = deg2rad($lat2);
    $lon2 = deg2rad($lon2);
    
    $dlat = $lat2 - $lat1;
    $dlon = $lon2 - $lon1;
    
    $a = sin($dlat/2) * sin($dlat/2) + cos($lat1) * cos($lat2) * sin($dlon/2) * sin($dlon/2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    
    $radius = 6371;
    $distance = $radius * $c;
    
    return $distance;
}

$locations = [
    ["nama" => "PMI A", "lat" => -6.978928, "lon" => 110.408140],
    ["nama" => "PMI B", "lat" => -6.966007, "lon" => 110.418171],
];

$penerimaDarah = [
    ["nama" => "Penerima 1", "lat" => -6.981548, "lon" => 110.409458],
    ["nama" => "Penerima 2", "lat" => -6.968607, "lon" => 110.416118],
];

foreach ($penerimaDarah as $penerima) {
    $jarakTerdekat = PHP_FLOAT_MAX;
    $pmiTerdekat = null;
    
    foreach ($locations as $lokasiPMI) {
        $jarak = haversine($penerima['lat'], $penerima['lon'], $lokasiPMI['lat'], $lokasiPMI['lon']);
        
        if ($jarak < $jarakTerdekat) {
            $jarakTerdekat = $jarak;
            $pmiTerdekat = $lokasiPMI;
        }
    }
    
    echo "Penerima {$penerima['nama']} terdekat dengan PMI {$pmiTerdekat['nama']}.\n";
}
?>
