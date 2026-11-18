
  const burger = document.querySelector(".navbar-burger");
  const menu = document.querySelector("#menuPrincipal");
  const campoNumero = document.getElementById("numero");
  const stockDisponible = 15;

  burger.addEventListener("click", () => {
    burger.classList.toggle("is-active");
    menu.classList.toggle("is-active");
  });

  const productoActual = {
    id: "airpods-pro-3",
    nombre: "AirPods Pro 3",
    precio: 84900,
    imagen: "../img/airpodspro3.png",
    enlace: window.location.href,
  };

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

  function obtenerPedidos() {
    try {
      return JSON.parse(localStorage.getItem("pedidos")) || [];
    } catch {
      return [];
    }
  }

  function pedir() {
    const cantidad = Number(campoNumero.value);
    const pedidos = obtenerPedidos();
    const existente = pedidos.find((p) => p.id === productoActual.id);

    if (existente) {
      existente.cantidad += cantidad;
    } else {
      pedidos.push({
        id: productoActual.id,
        nombre: productoActual.nombre,
        precio: productoActual.precio,
        imagen: productoActual.imagen,
        cantidad: cantidad,
      });
    }

    localStorage.setItem("pedidos", JSON.stringify(pedidos));
    window.location.href = "../cuenta/mispedidos.html";
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
    const guardado = favoritos.some((p) => p.id === productoActual.id);
    const boton = document.getElementById("favorito");

    boton.classList.toggle("activo", guardado);
    boton.setAttribute("aria-pressed", guardado);
    boton.setAttribute(
      "aria-label",
      guardado ? "Quitar de favoritos" : "Agregar a favoritos",
    );
  }

  function guardarFavorito() {
    const favoritos = obtenerFavoritos();
    const indice = favoritos.findIndex((p) => p.id === productoActual.id);

    if (indice !== -1) {
      favoritos.splice(indice, 1);
    } else {
      favoritos.push(productoActual);
    }

    localStorage.setItem("favoritos", JSON.stringify(favoritos));
    comprobarFavorito();
  }

  comprobarFavorito();
