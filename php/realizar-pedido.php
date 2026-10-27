<?php
require("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $telefono = $_POST["telefono"];
    $direccion = $_POST["direccion"];
    $ciudad = $_POST["ciudad"];
    $pago = $_POST["pago"]; 

    $sql = "INSERT INTO realizarpedido(nombre, correo, telefono, direccion, ciudad, pago) VALUES ('$nombre', '$correo', '$telefono', '$direccion', '$ciudad', '$pago')";
    if ($conn->query($sql) === TRUE) {
        echo "Usuario registrado exitosamente.";
        header("Location: ../cuenta/mispedidos.html");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();     
?>
