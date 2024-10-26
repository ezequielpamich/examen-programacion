<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo_ingresado = $_POST["confirmacion"];
    
    if ($codigo_ingresado === $_SESSION["codigos"]) {
        echo "Código correcto.";
    } else {
        echo "Código incorrecto. Intente de nuevo.";
    }
}
?>
