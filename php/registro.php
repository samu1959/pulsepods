<?php
require("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre         = trim($_POST["nombre"] ?? "");
    $correo         = trim($_POST["correo"] ?? "");
    $contrasena     = $_POST["contrasena"] ?? "";
    $fecha_registro = $_POST["fecha_registro"] ?? date("Y-m-d");
    $metodoEntrega  = $_POST["metodoEntrega"] ?? "";
    $documento      = $_POST["documento"] ?? "";
    $direccion      = $_POST["direccion"] ?? "";

    if ($nombre === "" || !filter_var($correo, FILTER_VALIDATE_EMAIL) || strlen($contrasena) < 8) {
        die("Datos inválidos.");
    }

    $hash = password_hash($contrasena, PASSWORD_DEFAULT);

    $stmt = $conn->prepare(
        "INSERT INTO usuario (nombre, correo, contrasena, fecha_registro, metodoEntrega, documento, direccion)
         VALUES (?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("sssssss", $nombre, $correo, $hash, $fecha_registro, $metodoEntrega, $documento, $direccion);

    if ($stmt->execute()) {
        header("Location: ../login_registro/login.html");
        exit;
    } else {
       
        error_log($stmt->error);
        echo "No se pudo registrar el usuario.";
    }
    $stmt->close();
}
$conn->close();
?>