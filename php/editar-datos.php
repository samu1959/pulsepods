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

UPDATE 'usuario'  SET  `nombre`='$nombre' ,  `correo`='$correo', `metodoEntrega`='metodoEntrega' , `direccion` = '$direccion' WHERE  id_usuario = 1;    if ($conn->query($sql) === TRUE) {
        echo "datos  actualizados exitosamente.";
        header("Location: ../login_registro/login.html");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();     
?>
