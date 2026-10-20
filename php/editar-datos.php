<?php
require("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $apellido = $_POST["apellido"];
    $confirmarContrasena = $_POST["confirmarContrasena"];
    $fecha = $_POST["fecha"];
    $telefono = $_POST["telefono"];
    $documento = $_POST["documento"];
    $direccion = $_POST["direccion"];
    $ciudad = $_POST["ciudad"];
    $departamento = $_POST["departamento"];
    $codigoPostal = $_POST["codigoPostal"];
    $metodoPago = $_POST["metodoPago"];
    $metodoentrega = $_POST["metodoentrega"];
    $metodoenvio = $_POST["metodoenvio"];

    $sql = "INSERT INTO usuarios(nombre, email, apellido, contrasena, confirmarContrasena, fecha, telefono, documento, direccion, ciudad, departamento, codigoPostal, metodoPago, metodoentrega, metodoenvio) VALUES ('$nombre', '$email', '$apellido', '$contrasena', '$confirmarContrasena', '$fecha', '$telefono', '$documento', '$direccion', '$ciudad', '$departamento', '$codigoPostal', '$metodoPago', '$metodoentrega', '$metodoenvio')";
    if ($conn->query($sql) === TRUE) {
        echo "Usuario registrado exitosamente.";
        header("Location: ../cuenta/editor-datos.html");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();     
?>
