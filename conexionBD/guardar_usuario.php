<?php
// Conectar a la base de datos
$servername = "localhost"; // Cambia esto si tu servidor de base de datos está en otro lugar
$username = "root"; // Cambia esto por tu usuario de base de datos
$password = ""; // No tiene contraseña
$dbname = "login"; // Cambia esto por el nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir los datos del formulario
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$correo = $_POST['correo'];
$contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT); // Encriptar la contraseña
$estado_id = 1; // Puedes establecer un estado como 'Activo' al registrar, o usar un formulario para elegirlo.

// Preparar y ejecutar la consulta
$sql = "INSERT INTO usuarios (nombres, apellidos, correo, contrasena, estado_id) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $nombres, $apellidos, $correo, $contrasena, $estado_id);

if ($stmt->execute()) {
    echo "Registro exitoso.";
} else {
    echo "Error: " . $stmt->error;
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
