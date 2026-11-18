
<?php
session_start();
require_once "conexion.php";

header("Content-Type: application/json; charset=UTF-8");

if (!isset($_SESSION["id_usuario"])) {
    http_response_code(401);
    echo json_encode(["mensaje" => "Debes iniciar sesión para realizar un pedido."]);
    exit();
}

$datos = json_decode(file_get_contents("php://input"), true);

$id_producto = (int) ($datos["id_producto"] ?? 0);
$cantidad = (int) ($datos["cantidad"] ?? 0);
$id_usuario = (int) $_SESSION["id_usuario"];

if ($id_producto <= 0 || $cantidad <= 0) {
    http_response_code(400);
    echo json_encode(["mensaje" => "Los datos del pedido no son válidos."]);
    exit();
}

try {
    $conn->begin_transaction();

    $stmt = $conn->prepare("SELECT precio, stock, estado FROM producto WHERE id_producto = ?");
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $producto = $resultado->fetch_assoc();
    $stmt->close();

    if (!$producto || $producto["estado"] !== "disponible") {
        throw new Exception("El producto no está disponible.");
    }

    if ($cantidad > (int) $producto["stock"]) {
        throw new Exception("No hay suficiente stock disponible.");
    }

    $stmt = $conn->prepare("INSERT INTO pedido (id_usuario) VALUES (?)");
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $id_pedido = $conn->insert_id;
    $stmt->close();

    $precio = (float) $producto["precio"];

    $stmt = $conn->prepare(
        "INSERT INTO detalle_pedido (id_pedido, id_producto, cantidad, precio_unitario)
         VALUES (?, ?, ?, ?)"
    );

    $stmt->bind_param("iiid", $id_pedido, $id_producto, $cantidad, $precio);
    $stmt->execute();
    $stmt->close();

    $conn->commit();

    echo json_encode(["mensaje" => "Pedido guardado correctamente."]);
} catch (Exception $e) {
    $conn->rollback();
    http_response_code(400);
    echo json_encode(["mensaje" => $e->getMessage()]);
}

$conn->close();
?>
