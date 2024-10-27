<?php
session_start(); // Iniciar sesión para acceder a la variable de sesión

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Asegúrate de que la ruta a autoload.php es correcta

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo_ingresado = $_POST["confirmacion"];
    
    if ($codigo_ingresado === $_SESSION["codigos"]) {
        // Establecer los datos del usuario en la sesión
        $_SESSION['nombres'] = $_POST['nombres'];
        $_SESSION['apellidos'] = $_POST['apellidos'];
        $_SESSION['correo'] = $_POST['correo'];
        $_SESSION['contrasena'] = $_POST['contrasena'];

        // Generar token de verificación
        $token = bin2hex(random_bytes(16));

        // Guardar el token en la sesión
        $_SESSION['token'] = $token;

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

        // Preparar la inserción del usuario
        $nombres = $_SESSION['nombres'];
        $apellidos = $_SESSION['apellidos'];
        $correo = $_SESSION['correo'];
        $contrasena = password_hash($_SESSION['contrasena'], PASSWORD_DEFAULT); 
        $estado_id = 2; // Usuario deshabilitado por defecto

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
                    echo "Registro exitoso. Enviando correo de verificación...";

                    // Enviar correo de verificación
                    $mail = new PHPMailer(true);
                    try {
                        // Configuración del servidor SMTP
                        $mail->SMTPDebug = 0; // Cambia a 2 o 3 para más detalles en caso de error
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'ezequielblanco528@gmail.com'; // Reemplaza con tu correo
                        $mail->Password = 'npux pxtj pdse yoqr'; // Reemplaza con tu contraseña o contraseña de aplicación
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // O 'tls'
                        $mail->Port = 587;

                        // Configuración del correo
                        $mail->setFrom('ezequielblanco528@gmail.com', 'Nombre');
                        $mail->addAddress($_SESSION['correo'], $_SESSION['nombres'] . ' ' . $_SESSION['apellidos']);

                        // Contenido del correo
                        $mail->isHTML(true);
                        $mail->Subject = 'Verificación de cuenta';
                        $mail->Body = "Haz clic en el siguiente enlace para verificar tu cuenta: <a href='http://localhost/examen-programacion/complementos-captchat/verificar.php?token=$token'>Verificar Cuenta</a>";

                        $mail->send();
                        echo 'El mensaje ha sido enviado. Por favor, revisa tu correo para verificar tu cuenta.';

                        // Aquí puedes limpiar la sesión si deseas hacerlo después de que el usuario verifique su cuenta
                    } catch (Exception $e) {
                        echo "Error al enviar el correo: {$mail->ErrorInfo}";
                    }
                } else {
                    echo "Error al guardar el usuario: " . $stmt->error;
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

    } else {
        echo "Código incorrecto. Intente de nuevo.";
        echo '<p><a href="../captchat.php">Volver a intentar</a></p>'; 
    }
}
?>
