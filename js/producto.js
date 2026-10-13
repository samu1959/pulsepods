const parametros = new URLSearchParams(window.location.search);
let id = Number(parametros.get("id"));
if (id === 0) {
    id = 1;
}

const producto = buscarProducto(id);
let cantidad = 1;

function pintarFavorito() {
    const corazon = document.getElementById("favorito");
    if (esFavorito(id)) {
        corazon.classList.add("activo");
    } else {
        corazon.classList.remove("activo");
    }
}

function sumar() {
    if (cantidad < producto.stock) {
        cantidad = cantidad + 1;
        document.getElementById("numero").value = cantidad;
    }
}

function restar() {
    if (cantidad > 1) {
        cantidad = cantidad - 1;
        document.getElementById("numero").value = cantidad;
    }
}

function guardarFavorito() {
    cambiarFavorito(id);
    pintarFavorito();
}

function pedir() {
    if (usuarioActual() === null) {
        alert("Inicia sesión para agregar pedidos");
        window.location.href = "../login/login.html";
        return;
    }

    if (producto.estado === "agotado" || producto.stock < 1) {
        alert("Este producto está agotado");
        return;
    }

    const carrito = leer("carrito", []);
    let yaEstaba = false;

    for (let i = 0; i < carrito.length; i++) {
        if (carrito[i].id === producto.id) {
            carrito[i].cantidad = carrito[i].cantidad + cantidad;
            yaEstaba = true;
        }
    }

    if (yaEstaba === false) {
        carrito.push({
            id: producto.id,
            nombre: producto.nombre,
            precio: producto.precio,
            imagen: producto.imagen,
            cantidad: cantidad
        });
    }

    guardar("carrito", carrito);
    window.location.href = "../cuenta/mispedidos.html";
}

if (producto === null) {
    window.location.href = "catalogo.html";
} else {
    document.title = "PulsePods - " + producto.nombre;
    document.getElementById("categoria").textContent = producto.categoria.toUpperCase();
    document.getElementById("nombre").textContent = producto.nombre;
    document.getElementById("precio").textContent = dinero(producto.precio);
    document.getElementById("descripcion").textContent = producto.descripcion;

    if (producto.estado === "agotado" || producto.stock < 1) {
        document.getElementById("stock").textContent = "Agotado";
    } else {
        document.getElementById("stock").textContent = producto.stock + " unidades";
    }

    if (producto.modelo === false) {
        document.getElementById("modelo3d").style.display = "none";
        const imagen = document.getElementById("imagenProducto");
        imagen.src = producto.imagen;
        imagen.style.display = "block";
    }

    pintarFavorito();
}