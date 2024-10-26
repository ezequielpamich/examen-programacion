<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo_ingresado = $_POST["confirmacion"];
    
    if ($codigo_ingresado === $_SESSION["codigos"]) {
        // Redirige a login.html si el código es correcto
        header("Location: ../login.html"); // Ajusta la ruta según la estructura de carpetas
        exit(); // Asegúrate de salir del script
    } else {
        echo "Código incorrecto. Intente de nuevo.";
        // También puedes agregar un enlace para volver a intentarlo
        echo '<p><a href="../index.php">Volver a intentar</a></p>'; // Cambia "index.php" por el nombre de tu archivo original
    }
}
?>
