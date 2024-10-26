<?php session_start(); // Start the session ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejemplo Captcha</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<section class="form-login">
    <h5>Verificación de CAPTCHA</h5>
    <?php
    // Generate random numbers and characters for the CAPTCHA
    $numero1 = rand(0, 9);
    $numero2 = rand(0, 9);
    $numero3 = rand(0, 9);
    $minus = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "ñ", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
    $mayus = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "Ñ", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
    $signos = array("!", "#", "$", "%", "&", "=");

    $generador_min = rand(0, count($minus) - 1);
    $generador_may = rand(0, count($mayus) - 1);
    $generador_sig = rand(0, count($signos) - 1);

    // Store the CAPTCHA code in the session
    $_SESSION["codigos"] = $numero1 . $minus[$generador_min] . $numero2 . $mayus[$generador_may] . $signos[$generador_sig] . $numero3;

    // Display the CAPTCHA image (assuming imagen2.php generates the image)
    echo "<img src='imagen2.php' alt='Captcha' />";
    ?>
    <form action="confirmacion2.php" method="post">
        <label for="confirmacion">Escriba código de seguridad:</label>
        <input name="confirmacion" type="text" id="confirmacion" class="controls" required />
        <p>
            <input type="submit" name="Submit" value="Comprobar" class="buttons" />
        </p>
    </form>
</section>
</body>
</html>
