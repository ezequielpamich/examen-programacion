<?php
session_start(); // Iniciar sesión para acceder a la variable de sesión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo_ingresado = $_POST["confirmacion"];
    
    if ($codigo_ingresado === $_SESSION["codigos"]) {
        // Establecer los datos del usuario en la sesión
        $_SESSION['nombres'] = $_POST['nombres'];
        $_SESSION['apellidos'] = $_POST['apellidos'];
        $_SESSION['correo'] = $_POST['correo'];
        $_SESSION['contrasena'] = $_POST['contrasena'];

        // Redirige a guardar_usuario.php para procesar el registro
        header("Location: ../conexionBD/guardar_usuario.php"); // Ajusta la ruta según la estructura de carpetas
        exit(); // Asegúrate de salir del script
    } else {
        echo "Código incorrecto. Intente de nuevo.";
        echo '<p><a href="../captchat.php">Volver a intentar</a></p>'; 
    }
}
?>
