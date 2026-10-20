<?php
require("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];
    $confirmarContrasena = $_POST["confirmarContrasena"];
    $fecha = $_POST["fecha"];
    $telefono = $_POST["telefono"];
    $documento = $_POST["documento"];

    $sql = "INSERT INTO usuarios(nombre, email, contrasena, confirmarContrasena, fecha, telefono, documento) VALUES ('$nombre', '$email', '$contrasena', '$confirmarContrasena', '$fecha', '$telefono', '$documento')";
    if ($conn->query($sql) === TRUE) {
        echo "Usuario registrado exitosamente.";
        header("Location: ../login y registro/login.html");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();     
?>
