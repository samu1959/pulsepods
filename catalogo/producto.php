
<?php
require_once "../php/conexion.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    die("Producto no válido.");
}

$id = (int) $_GET["id"];

$stmt = $conn->prepare("SELECT * FROM producto WHERE id_producto = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();
$producto = $resultado->fetch_assoc();
$stmt->close();

if (!$producto) {
    die("El producto no existe.");
}

$nombre = $producto["nombre"];
$precio = (float) $producto["precio"];
$descripcion = $producto["descripcion"];
$imagen = $producto["imagen"] ?? "";
$stock = (int) $producto["stock"];
$categoria = $producto["categoria"];

$productoJS = [
    "id" => (string) $producto["id_producto"],
    "nombre" => $nombre,
    "precio" => $precio,
    "imagen" => $imagen,
    "enlace" => "producto.php?id=" . $id
];
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css" />
    <link rel="stylesheet" href="../css/producto.css" />
    <title>PulsePods</title>
</head>

<body>
    <nav class="navbar" role="navigation" aria-label="main navigation">
        <div class="container">
            <div class="navbar-brand">
                <a class="navbar-item" href="../inicio/index.html">
                    <strong class="is-size-4">PULSEPODS</strong>
                </a>

                <a
                    role="button"
                    class="navbar-burger"
                    aria-label="menu"
                    aria-expanded="false"
                    data-target="menuPrincipal">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>

            <div id="menuPrincipal" class="navbar-menu">
                <div class="navbar-end">
                    <a class="navbar-item" href="../inicio/index.html">Inicio</a>
                    <a class="navbar-item" href="catalogo.php">Catálogo</a>
                    <a class="navbar-item" href="../cuenta/favoritos.html">Favoritos</a>
                    <a class="navbar-item" href="../cuenta/mispedidos.php">Mis Pedidos</a>
                    <a class="navbar-item" href="../cuenta/cuenta.php">Cuenta</a>
                </div>
            </div>
        </div>
    </nav>

    <section class="section">
        <div class="container">
            <div class="columns is-vcentered is-variable is-8">
                <div class="column is-7">
                    <div class="card">
                        <div class="card-content">
                            <div class="model-container">
                                <iframe
                                    title="AirPods Pro 3"
                                    frameborder="0"
                                    allowfullscreen
                                    mozallowfullscreen="true"
                                    webkitallowfullscreen="true"
                                    allow="autoplay; fullscreen; xr-spatial-tracking"
                                    xr-spatial-tracking
                                    execution-while-out-of-viewport
                                    execution-while-not-rendered
                                    web-share
                                    src="https://sketchfab.com/models/2209c17723a54331985cc080eda35266/embed">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="column is-5">
                    <div class="card">
                        <div class="card-content">
                            <p class="is-size-7 has-text-weight-bold mb-2">AUDÍFONOS</p>

                            <h1 class="title is-2 mb-3">
                                <?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'); ?>
                            </h1>

                            <p class="title is-3 mb-5">
                                $<?php echo number_format($precio, 0, ',', '.'); ?>
                            </p>

                            <div class="content">
                                <p>
                                    <?php echo nl2br(htmlspecialchars($descripcion, ENT_QUOTES, 'UTF-8')); ?>
                                </p>
                            </div>

                            <div class="notification is-light mb-5">
                                <strong>Disponibilidad:</strong>
                                <span id="stock">
                                    <?php echo $stock; ?> unidades
                                </span>
                            </div>

                            <div class="cantidad-favorito">
                                <div class="cantidad-contenedor">
                                    <p class="cantidad-titulo">Cantidad</p>

                                    <div class="buttons has-addons">
                                        <button class="button cantidad-boton" type="button" onclick="restar()">
                                            −
                                        </button>

                                        <input
                                            id="numero"
                                            name="numero"
                                            class="input cantidad-input"
                                            type="text"
                                            value="1"
                                            readonly />

                                        <button class="button cantidad-boton" type="button" onclick="sumar()">
                                            +
                                        </button>
                                    </div>
                                </div>

                                <button
                                    type="button"
                                    id="favorito"
                                    class="boton-corazon"
                                    aria-label="Agregar a favoritos"
                                    onclick="guardarFavorito()">
                                    <svg width="1em" height="1em" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                    </svg>
                                </button>
                            </div>

                            <div class="field mt-5">
                                <div class="control">
                                    <button
                                        class="button is-primary is-medium is-fullwidth"
                                        type="button"
                                        onclick="pedir()">
                                        Agregar pedido
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="columns mt-6">
                <div class="column">
                    <div class="card">
                        <div class="card-content">
                            <h2 class="title is-4">Características del producto</h2>

                            <div class="content">
                                <ul>
                                    <li>Conexión Bluetooth</li>
                                    <li>Estuche de carga</li>
                                    <li>Diseño inalámbrico</li>
                                    <li>Micrófono integrado</li>
                                    <li>Control táctil</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        const burger = document.querySelector(".navbar-burger");
        const menu = document.querySelector("#menuPrincipal");
        const campoNumero = document.getElementById("numero");
        const stockDisponible = <?php echo $stock; ?>;

        burger.addEventListener("click", () => {
            burger.classList.toggle("is-active");
            menu.classList.toggle("is-active");
        });

        const productoActual = <?php
            echo json_encode(
                $productoJS,
                JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP
            );
        ?>;

        function sumar() {
            const cantidad = Number(campoNumero.value);

            if (cantidad < stockDisponible) {
                campoNumero.value = cantidad + 1;
            }
        }

        function restar() {
            const cantidad = Number(campoNumero.value);

            if (cantidad > 1) {
                campoNumero.value = cantidad - 1;
            }
        }

        async function pedir() {
            const cantidad = Number(campoNumero.value);

            if (!Number.isInteger(cantidad) || cantidad < 1) {
                alert("Selecciona una cantidad válida.");
                return;
            }

            if (cantidad > stockDisponible) {
                alert("No hay suficiente stock disponible.");
                return;
            }

            try {
                const respuesta = await fetch("../php/agregarPedido.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        id_producto: productoActual.id,
                        cantidad: cantidad
                    })
                });

                const resultado = await respuesta.json();

                if (!respuesta.ok) {
                    alert(resultado.mensaje || "No se pudo guardar el pedido.");
                    return;
                }

                alert(resultado.mensaje);
                window.location.href = "../cuenta/mispedidos.php";

            } catch (error) {
                alert("No se pudo conectar con el servidor.");
            }
        }

        function obtenerFavoritos() {
            try {
                return JSON.parse(localStorage.getItem("favoritos")) || [];
            } catch {
                return [];
            }
        }

        function comprobarFavorito() {
            const favoritos = obtenerFavoritos();

            const guardado = favoritos.some(
                p => String(p.id) === String(productoActual.id)
            );

            const boton = document.getElementById("favorito");

            boton.classList.toggle("activo", guardado);
            boton.setAttribute("aria-pressed", guardado);
            boton.setAttribute(
                "aria-label",
                guardado ? "Quitar de favoritos" : "Agregar a favoritos"
            );
        }

        function guardarFavorito() {
            const favoritos = obtenerFavoritos();

            const indice = favoritos.findIndex(
                p => String(p.id) === String(productoActual.id)
            );

            if (indice !== -1) {
                favoritos.splice(indice, 1);
            } else {
                favoritos.push(productoActual);
            }

            localStorage.setItem("favoritos", JSON.stringify(favoritos));
            comprobarFavorito();
        }

        comprobarFavorito();
    </script>
</body>

</html>
