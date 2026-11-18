<?php
require("conexion.php");

session_start();   

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];
}

$sql = "SELECT * FROM usuario WHERE correo = '$email' AND contrasena = '$contrasena'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $_SESSION['usuario'] = $email;
    echo "Inicio de sesión exitoso.";
    header("Location: ../inicio/index.html");
} else {
    echo "Credenciales incorrectas.";
}


if (isset($_SESSION['usuario'])) {
    echo "La variable existe y su valor es: " . $_SESSION['usuario'];
} else {
    echo "La variable de sesión 'usuario' no está definida.";
}
?>

$conn->close(); 