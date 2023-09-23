<?php

function applyMedianFilter($inputImage) {
    $outputImage = $inputImage;

    $width = imagesx($inputImage);
    $height = imagesy($inputImage);

    $windowSize = 6;

    for ($x = 0; $x < $width; $x++) {
        for ($y = 0; $y < $height; $y++) {
            $pixels = array();

            for ($i = -$windowSize; $i <= $windowSize; $i++) {
                for ($j = -$windowSize; $j <= $windowSize; $j++) {

                    $xx = min(max($x + $i, 0), $width - 1);
                    $yy = min(max($y + $j, 0), $height - 1);

                    $pixels[] = imagecolorat($inputImage, $xx, $yy);
                }
            }

            sort($pixels);

            $medianPixel = $pixels[count($pixels) / 2];
            imagesetpixel($outputImage, $x, $y, $medianPixel);
        }
    }

    return $outputImage;
}

$inputImage = imagecreatefromjpeg('input.jpeg');

$outputImage = applyMedianFilter($inputImage);

imagejpeg($outputImage, 'output.jpeg');

echo "Median Filter telah diterapkan ke citra.";
