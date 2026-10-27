<?php
require("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];
    $fecha_registro = $_POST["fecha_registro"];
    $metodoEntrega = $_POST["metodoEntrega"];
    $documento = $_POST["documento"];
    $direccion = $_POST["direccion"];

 $sql = "INSERT INTO usuario(nombre, correo, contrasena, fecha_registro , metodoEntrega , direccion) VALUES ('$nombre', '$correo', '$contrasena', '$fecha_registro', '$metodoEntrega' , '$direccion')";
    if ($conn->query($sql) === TRUE) {
        echo "Usuario registrado exitosamente.";
        header("Location: ../login_registro/login.html");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();     
?>
