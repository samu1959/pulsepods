
<?php
session_start();
require("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];

    $sql = "SELECT id_usuario, correo FROM usuario WHERE correo = ? AND contrasena = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $contrasena);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();

        $_SESSION["id_usuario"] = $usuario["id_usuario"];
        $_SESSION["usuario"] = $usuario["correo"];

        header("Location: ../inicio/index.html");
        exit();
    } else {
        echo "Credenciales incorrectas.";
    }

    $stmt->close();
}

$conn->close();
?>
