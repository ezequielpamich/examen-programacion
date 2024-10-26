<?php
session_start(); // Iniciar sesión para acceder a la variable de sesión

// Conectar a la base de datos
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "login";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si las variables de sesión están establecidas
if (isset($_SESSION['nombres'], $_SESSION['apellidos'], $_SESSION['correo'], $_SESSION['contrasena'])) {
    // Recibir los datos del usuario desde la sesión
    $nombres = $_SESSION['nombres'];
    $apellidos = $_SESSION['apellidos'];
    $correo = $_SESSION['correo'];
    $contrasena = password_hash($_SESSION['contrasena'], PASSWORD_DEFAULT); 
    $estado_id = 2;

    // Verificar si el correo ya existe
    $sql_check = "SELECT * FROM usuarios WHERE correo = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $correo);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        echo "El correo ya está registrado.";
    } else {
        // Preparar la consulta de inserción
        $sql = "INSERT INTO usuarios (nombres, apellidos, correo, contrasena, estado_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("ssssi", $nombres, $apellidos, $correo, $contrasena, $estado_id);

            if ($stmt->execute()) {
                echo "Registro exitoso.";
                // Limpiar la sesión después del registro exitoso
                session_unset();
                session_destroy();
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Error al preparar la consulta: " . $conn->error;
        }
    }

    // Cerrar la conexión
    $stmt_check->close();
    if (isset($stmt)) {
        $stmt->close();
    }
} else {
    echo "No se encontraron datos de usuario en la sesión.";
}

// Cerrar la conexión
$conn->close();