<?php session_start(); // Iniciar sesión para usar la variable de sesión ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>Formulario Registro</title>
</head>
<body>
    <section class="form-register">
        <h4>Formulario Registro</h4>
        <form action="./complementos-captchat/confirmacion2.php" method="post"> 
            <input class="controls" type="text" name="nombres" placeholder="Ingrese su Nombre" required>
            <input class="controls" type="text" name="apellidos" placeholder="Ingrese su Apellido" required>
            <input class="controls" type="email" name="correo" placeholder="Ingrese su Correo" required>
            <input class="controls" type="password" name="contrasena" placeholder="Ingrese su Contraseña" required> 

            <?php
            // Generar números aleatorios y caracteres para el CAPTCHA
            $numero1 = rand(0, 9);
            $numero2 = rand(0, 9);
            $numero3 = rand(0, 9);
            $minus = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "ñ", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
            $mayus = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "Ñ", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
            $signos = array("!", "#", "$", "%", "&", "=");

            $generador_min = rand(0, count($minus) - 1);
            $generador_may = rand(0, count($mayus) - 1);
            $generador_sig = rand(0, count($signos) - 1);

            // Almacenar el código CAPTCHA en la sesión
            $_SESSION["codigos"] = $numero1 . $minus[$generador_min] . $numero2 . $mayus[$generador_may] . $signos[$generador_sig] . $numero3;

            // Mostrar la imagen CAPTCHA
            echo "<img src='./complementos-captchat/imagen2.php' alt='Captcha' />";
            ?>

            <label for="confirmacion">Escriba código de seguridad:</label>
            <input name="confirmacion" type="text" id="confirmacion" class="controls" required />
            
            <input class="botons" type="submit" value="Registrar">
            <p><a href="login.html">¿Ya tengo Cuenta?</a></p>
        </form>
    </section>
</body>
</html>
