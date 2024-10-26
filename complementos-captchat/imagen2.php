<?php
session_start();
header("Content-type: image/jpeg");

// Create an image
$im = @imagecreate(100, 30);
if (!$im) {
    die('Failed to create image.');
}

// Allocate colors
$color_fondo = imagecolorallocate($im, 240, 240, 240); // Light gray background
$color_texto = imagecolorallocate($im, 0, 128, 6); // Dark green text

// Add the text from the session to the image
imagestring($im, 5, 10, 5, $_SESSION["codigos"], $color_texto);

// Output the image
imagejpeg($im);
imagedestroy($im); // Free up memory
?>
