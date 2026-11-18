
<?php
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../admin/agregar-producto.html");
    exit;
}

$nombre = trim($_POST["nombre"] ?? "");
$descripcion = trim($_POST["descripcion"] ?? "");
$precio = $_POST["precio"] ?? "";
$stock = $_POST["stock"] ?? "";
$imagen = trim($_POST["imagen"] ?? "");
$categoria = $_POST["categoria"] ?? "audifonos";
$estado = $_POST["estado"] ?? "disponible";

if (
    $nombre === "" ||
    $descripcion === "" ||
    $imagen === "" ||
    !is_numeric($precio) ||
    !filter_var($stock, FILTER_VALIDATE_INT) ||
    (float)$precio < 0 ||
    (int)$stock < 0
) {
    die("Error: revisa los datos del formulario.");
}

if (!in_array($categoria, ["audifonos", "accesorios", "otros"], true)) {
    die("Categoría no válida.");
}

if (!in_array($estado, ["disponible", "agotado", "oculto"], true)) {
    die("Estado no válido.");
}

$sql = "INSERT INTO producto
        (nombre, descripcion, precio, stock, imagen, categoria, estado)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error al preparar la consulta: " . $conn->error);
}

$precio = (float)$precio;
$stock = (int)$stock;

$stmt->bind_param(
    "ssdisss",
    $nombre,
    $descripcion,
    $precio,
    $stock,
    $imagen,
    $categoria,
    $estado
);

if ($stmt->execute()) {
    header("Location: ../admin/agregar-producto.html?resultado=ok");
    exit;
}

echo "Error al guardar el producto: " . $stmt->error;

$stmt->close();
$conn->close();
?>
