
<?php
session_start();
require_once "../php/conexion.php";

if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login y register/login.html");
    exit();
}

$id_usuario = (int) $_SESSION["id_usuario"];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["quitar"])) {
    $id_detalle = (int) $_POST["id_detalle"];

    $conn->begin_transaction();

    try {
        $stmt = $conn->prepare(
            "DELETE dp FROM detalle_pedido dp
             INNER JOIN pedido p ON dp.id_pedido = p.id_pedido
             WHERE dp.id_detalle = ? AND p.id_usuario = ?"
        );

        $stmt->bind_param("ii", $id_detalle, $id_usuario);
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare(
            "DELETE p FROM pedido p
             LEFT JOIN detalle_pedido dp ON p.id_pedido = dp.id_pedido
             WHERE p.id_usuario = ? AND dp.id_detalle IS NULL"
        );

        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $stmt->close();

        $conn->commit();

    } catch (Exception $e) {
        $conn->rollback();
        die("No se pudo quitar el producto del pedido.");
    }

    header("Location: mispedidos.php");
    exit();
}

$sql = "SELECT
            p.id_pedido,
            p.fecha_creacion,
            dp.id_detalle,
            dp.id_producto,
            dp.cantidad,
            dp.precio_unitario,
            pr.nombre,
            pr.imagen
        FROM pedido p
        INNER JOIN detalle_pedido dp
            ON p.id_pedido = dp.id_pedido
        INNER JOIN producto pr
            ON dp.id_producto = pr.id_producto
        WHERE p.id_usuario = ?
        ORDER BY p.fecha_creacion DESC, p.id_pedido DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();

$resultado = $stmt->get_result();

$pedidos = [];
$totalProductos = 0;
$totalPedido = 0;

while ($fila = $resultado->fetch_assoc()) {
    $id = $fila["id_pedido"];

    if (!isset($pedidos[$id])) {
        $pedidos[$id] = [
            "fecha" => $fila["fecha_creacion"],
            "productos" => [],
            "total" => 0
        ];
    }

    $subtotal = (float) $fila["precio_unitario"] * (int) $fila["cantidad"];

    $pedidos[$id]["productos"][] = [
        "id_detalle" => $fila["id_detalle"],
        "id_producto" => $fila["id_producto"],
        "nombre" => $fila["nombre"],
        "imagen" => $fila["imagen"],
        "cantidad" => $fila["cantidad"],
        "precio" => $fila["precio_unitario"],
        "subtotal" => $subtotal
    ];

    $pedidos[$id]["total"] += $subtotal;
    $totalProductos += (int) $fila["cantidad"];
    $totalPedido += $subtotal;
}

$stmt->close();

function formatoPrecio($valor) {
    return "$" . number_format((float) $valor, 0, ',', '.');
}
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css"
    />
    <link rel="stylesheet" href="../css/mispedidos.css" />
    <title>PulsePods - Mis pedidos</title>
</head>

<body>
    <nav class="navbar" role="navigation" aria-label="main navigation">
        <div class="container">
            <div class="navbar-brand">
                <a class="navbar-item logo" href="../inicio/index.html">PULSEPODS</a>

                <a
                    role="button"
                    class="navbar-burger"
                    id="burger"
                    aria-label="menu"
                    aria-expanded="false"
                >
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>

            <div class="navbar-menu" id="menu">
                <div class="navbar-end">
                    <a class="navbar-item" href="../inicio/index.html">Inicio</a>
                    <a class="navbar-item" href="../catalogo/catalogo.php">Catálogo</a>
                    <a class="navbar-item" href="favoritos.html">Favoritos</a>
                    <a class="navbar-item" href="mispedidos.php">Mis pedidos</a>
                    <a class="navbar-item" href="cuenta.php">Cuenta</a>
                </div>
            </div>
        </div>
    </nav>

    <section class="section">
        <div class="container">
            <div class="has-text-centered mb-6">
                <h1 class="title is-1">Mis pedidos</h1>
                <p class="subtitulo">Consulta los productos y detalles de tu pedido</p>
            </div>

            <?php if (empty($pedidos)): ?>

                <div class="box pedido-vacio">
                    <h2>No tienes productos en tu pedido</h2>
                    <p>Agrega productos desde nuestro catálogo.</p>
                    <a href="../catalogo/catalogo.php" class="button boton-principal mt-4">
                        Ir al catálogo
                    </a>
                </div>

            <?php else: ?>

                <div class="columns is-variable is-5">
                    <div class="column is-8">

                        <?php foreach ($pedidos as $id_pedido => $pedido): ?>

                            <div class="box">
                                <h2 class="title is-4">
                                    Pedido #PP-<?php echo str_pad($id_pedido, 4, "0", STR_PAD_LEFT); ?>
                                </h2>

                                <p class="mb-4">
                                    Fecha:
                                    <?php echo date("d/m/Y", strtotime($pedido["fecha"])); ?>
                                </p>

                                <?php foreach ($pedido["productos"] as $p): ?>

                                    <div class="columns is-vcentered is-mobile">
                                        <div class="column is-3">
                                            <figure class="image">
                                                <?php if (!empty($p["imagen"])): ?>
                                                    <img
                                                        src="<?php echo htmlspecialchars($p["imagen"], ENT_QUOTES, "UTF-8"); ?>"
                                                        alt="<?php echo htmlspecialchars($p["nombre"], ENT_QUOTES, "UTF-8"); ?>"
                                                    />
                                                <?php else: ?>
                                                    <p>Imagen no disponible</p>
                                                <?php endif; ?>
                                            </figure>
                                        </div>

                                        <div class="column">
                                            <h3 class="title is-5 mb-2">
                                                <?php echo htmlspecialchars($p["nombre"], ENT_QUOTES, "UTF-8"); ?>
                                            </h3>

                                            <p>Cantidad: <?php echo (int) $p["cantidad"]; ?></p>

                                            <p>
                                                Precio unitario:
                                                <?php echo formatoPrecio($p["precio"]); ?>
                                            </p>

                                            <p>
                                                <strong>
                                                    Subtotal:
                                                    <?php echo formatoPrecio($p["subtotal"]); ?>
                                                </strong>
                                            </p>
                                        </div>

                                        <div class="column is-narrow">
                                            <form method="POST" action="mispedidos.php">
                                                <input
                                                    type="hidden"
                                                    name="id_detalle"
                                                    value="<?php echo (int) $p["id_detalle"]; ?>"
                                                />
                                                <button
                                                    type="submit"
                                                    name="quitar"
                                                    class="button is-small"
                                                >
                                                    Quitar
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <?php if ($p !== end($pedido["productos"])): ?>
                                        <hr />
                                    <?php endif; ?>

                                <?php endforeach; ?>

                                <hr />

                                <p class="has-text-right">
                                    <strong>
                                        Total del pedido:
                                        <?php echo formatoPrecio($pedido["total"]); ?>
                                    </strong>
                                </p>

                                <div class="detalle mt-4">
                                    <span class="detalle-titulo">Estado</span>
                                    <span class="estado">Pendiente</span>
                                </div>

                                <div class="detalle">
                                    <span class="detalle-titulo">Método de pago</span>
                                    <span class="detalle-valor">Por seleccionar</span>
                                </div>

                                <div class="detalle">
                                    <span class="detalle-titulo">Tipo de envío</span>
                                    <span class="detalle-valor">Envío estándar</span>
                                </div>
                            </div>

                        <?php endforeach; ?>

                    </div>

                    <div class="column is-4">
                        <div class="box resumen">
                            <h2 class="title is-3">Resumen</h2>

                            <div class="resumen-fila">
                                <span>Productos</span>
                                <span><?php echo $totalProductos; ?></span>
                            </div>

                            <div class="resumen-fila">
                                <span>Envío</span>
                                <span>Gratis</span>
                            </div>

                            <div class="resumen-total">
                                <span>Total</span>
                                <span><?php echo formatoPrecio($totalPedido); ?></span>
                            </div>

                            <a href="realizar-pedido.html" class="button boton-principal mt-4">
                                Realizar pedido
                            </a>
                        </div>
                    </div>
                </div>

            <?php endif; ?>
        </div>
    </section>

    <script>
        const burger = document.getElementById("burger");
        const menu = document.getElementById("menu");

        burger.addEventListener("click", () => {
            burger.classList.toggle("is-active");
            menu.classList.toggle("is-active");
        });
    </script>
</body>

</html>
