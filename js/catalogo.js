const lista = document.getElementById("listaCatalogo");
const cajaBusqueda = document.getElementById("buscar");

function mostrar() {
    const texto = cajaBusqueda.value.toLowerCase();
    const tarjetas = lista.querySelectorAll(".column");
    let encontrados = 0;

    tarjetas.forEach(function(columna) {
        const tarjeta = columna.querySelector(".producto-card");

        if (!tarjeta) return;

        const nombre = tarjeta.dataset.nombre.toLowerCase();
        const coincide = nombre.includes(texto);

        columna.style.display = coincide ? "" : "none";

        if (coincide) {
            encontrados++;
        }
    });

    let mensaje = document.getElementById("mensajeSinProductos");

    if (encontrados === 0) {
        if (!mensaje) {
            mensaje = document.createElement("p");
            mensaje.id = "mensajeSinProductos";
            mensaje.className = "subtitle";
            mensaje.style.color = "white";
            mensaje.textContent = "No se encontraron productos";
            lista.appendChild(mensaje);
        }
    } else if (mensaje) {
        mensaje.remove();
    }
}

function abrirProducto(id) {
    window.location.href = "producto.php?id=" + encodeURIComponent(id);
}