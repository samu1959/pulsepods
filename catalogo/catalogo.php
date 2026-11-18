<?php
require_once "../php/conexion.php";

$sql = "SELECT * FROM producto
        WHERE estado = 'disponible'
        AND stock > 0
        ORDER BY fecha_creacion DESC";

$resultado = $conn->query($sql);

if (!$resultado) {
  die("Error al consultar productos: " . $conn->error);
}
?>


<!doctype html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css" />
  <link rel="stylesheet" href="../css/catalogo.css" />
  <title>PulsePods - Catálogo</title>
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
          aria-expanded="false">
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
        </a>
      </div>

      <div class="navbar-menu" id="menu">
        <div class="navbar-busqueda">
          <div class="field has-addons">
            <div class="control is-expanded">
              <input
                class="input barra-busqueda"
                id="buscarproductos"
                name="buscarproductos"
                type="text"
                placeholder="Buscar productos..." />
            </div>
            <div class="control">
              <button class="button boton-busqueda">Buscar</button>
            </div>
          </div>
        </div>

        <div class="navbar-end">
          <a class="navbar-item" href="../inicio/index.html">Inicio</a>
          <a class="navbar-item" href="catalogo.php">Catálogo</a>
          <a class="navbar-item" href="../cuenta/favoritos.html">Favoritos</a>
          <a class="navbar-item" href="../cuenta/mispedidos.php">Mis pedidos</a>
          <a class="navbar-item" href="../cuenta/cuenta.php">Cuenta</a>
        </div>
      </div>
    </div>
  </nav>

  <section class="section">
    <div class="container">
      <div class="has-text-centered mb-6">
        <h1 class="title is-1">Productos</h1>
        <p class="subtitle">Encuentra tus PulsePods favoritos</p>
      </div>


      <div class="columns is-multiline">
        <?php if ($resultado->num_rows > 0): ?>
          <?php while ($producto = $resultado->fetch_assoc()): ?>
            <div class="column is-4">
              <div
                class="card producto-card"
                data-id="<?php echo htmlspecialchars($producto['id_producto']); ?>"
                data-nombre="<?php echo htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8'); ?>"
                data-precio="<?php echo htmlspecialchars($producto['precio']); ?>"
                data-imagen="<?php echo htmlspecialchars($producto['imagen'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                onclick="abrirProducto(<?php echo (int)$producto['id_producto']; ?>)">
                <div class="card-image">
                  <figure class="image is-4by5">
                    <img
                      src="<?php echo htmlspecialchars($producto['imagen'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                      alt="<?php echo htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8'); ?>" />
                  </figure>
                </div>

                <div class="card-content">
                  <div class="producto-encabezado">
                    <h2 class="producto-nombre">
                      <?php echo htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8'); ?>
                    </h2>

                    <button
                      class="boton-corazon"
                      aria-label="Agregar a favoritos"
                      onclick="favorito(event, this)">
                      <svg width="1em" height="1em" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                      </svg>
                    </button>
                  </div>

                  <p class="producto-descripcion">
                    <?php echo htmlspecialchars($producto['descripcion'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                  </p>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <div class="column is-12">
            <p class="has-text-centered">
              No hay productos disponibles en este momento.
            </p>
          </div>
        <?php endif; ?>
      </div>

    </div>
  </section>


  <script>
    const burger = document.getElementById("burger");
    const menu = document.getElementById("menu");

    burger.addEventListener("click", () => {
      burger.classList.toggle("is-active");
      menu.classList.toggle("is-active");
    });

    function abrirProducto(id) {
      window.location.href = "producto.php?id=" + encodeURIComponent(id);
    }

    function obtenerFavoritos() {
      try {
        return JSON.parse(localStorage.getItem("favoritos")) || [];
      } catch {
        return [];
      }
    }

    function favorito(event, boton) {
      event.stopPropagation();

      const card = boton.closest(".producto-card");

      const producto = {
        id: String(card.dataset.id),
        nombre: card.dataset.nombre,
        precio: Number(card.dataset.precio),
        imagen: card.dataset.imagen,
        enlace: "producto.php?id=" + encodeURIComponent(card.dataset.id)
      };

      const favoritos = obtenerFavoritos();
      const posicion = favoritos.findIndex(p => String(p.id) === producto.id);

      if (posicion !== -1) {
        favoritos.splice(posicion, 1);
      } else {
        favoritos.push(producto);
      }

      localStorage.setItem("favoritos", JSON.stringify(favoritos));
      pintarCorazones();
    }

    function pintarCorazones() {
      const favoritos = obtenerFavoritos();

      document.querySelectorAll(".producto-card").forEach(card => {
        const guardado = favoritos.some(p => String(p.id) === String(card.dataset.id));
        const boton = card.querySelector(".boton-corazon");

        boton.classList.toggle("activo", guardado);
        boton.setAttribute(
          "aria-label",
          guardado ? "Quitar de favoritos" : "Agregar a favoritos"
        );
      });
    }

    pintarCorazones();
  </script>

</body>

</html>