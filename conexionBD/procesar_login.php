<?php
// Conectar a la base de datos
$servername = "localhost";
$username = "root"; // Cambia esto si tu usuario es diferente
$password = ""; // No tiene contraseña
$dbname = "login"; // Cambia esto por el nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir los datos del formulario
$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];

// Preparar y ejecutar la consulta para verificar el usuario
$sql = "SELECT * FROM usuarios WHERE correo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();

    // Verificar el estado del usuario
    if ($usuario['estado_id'] == 2) {
        echo "El usuario está inactivo y no puede iniciar sesión.";
    } else {
        // Verificar la contraseña
        if (password_verify($contrasena, $usuario['contrasena'])) {
            // Contraseña correcta, redirigir a la página de login exitoso
            header("Location: ../login exitoso.html");
            exit(); // Asegúrate de llamar a exit después de header
        } else {
            echo "Contraseña incorrecta.";
        }
    }
} else {
    echo "El correo no está registrado.";
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
