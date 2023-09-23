<?php
function rinfo_encrypt($plaintext, $key) {
    $ciphertext = '';
    $keyLength = strlen($key);
    
    for ($i = 0; $i < strlen($plaintext); $i++) {
        $char = $plaintext[$i];
        $keyChar = $key[$i % $keyLength];
        $ciphertext .= chr(ord($char) + ord($keyChar));
    }
    
    return base64_encode($ciphertext);
}

function rinfo_decrypt($ciphertext, $key) {
    $ciphertext = base64_decode($ciphertext);
    $plaintext = '';
    $keyLength = strlen($key);
    
    for ($i = 0; $i < strlen($ciphertext); $i++) {
        $char = $ciphertext[$i];
        $keyChar = $key[$i % $keyLength];
        $plaintext .= chr(ord($char) - ord($keyChar));
    }
    
    return $plaintext;
}

$plaintext = "Ini adalah teks rahasia.";
$key = "kunci-rahasia";

$encryptedText = rinfo_encrypt($plaintext, $key);
echo "Teks Terenkripsi: $encryptedText<br>";

$decryptedText = rinfo_decrypt($encryptedText, $key);
echo "Teks Terdekripsi: $decryptedText<br>";
