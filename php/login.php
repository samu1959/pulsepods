<?php
require("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];
}

$sql = "INSERT INTO usuarios (nombre, email, contrasena) VALUES ('$nombre', '$email', '$contrasena')";
if ($conn->query($sql) === TRUE) {
    echo "Usuario registrado exitosamente.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

session_start();


if (isset($_SESSION['usuario'])) {
    echo "La variable existe y su valor es: " . $_SESSION['usuario'];
} else {
    echo "La variable de sesión 'usuario' no está definida.";
}
?>

$conn->close(); 