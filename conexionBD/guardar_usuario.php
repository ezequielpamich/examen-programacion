<?php
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

// Recibir los datos del formulario
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$correo = $_POST['correo'];
$contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT); 
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
    
    $sql = "INSERT INTO usuarios (nombres, apellidos, correo, contrasena, estado_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) { // Verifica si se pudo preparar la consulta
        $stmt->bind_param("ssssi", $nombres, $apellidos, $correo, $contrasena, $estado_id);

        if ($stmt->execute()) {
            echo "Registro exitoso.";
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
$conn->close();
?>
