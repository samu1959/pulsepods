const lista = document.getElementById("listaCatalogo");
const cajaBusqueda = document.getElementById("buscar");

function mostrar() {
    const texto = cajaBusqueda.value.toLowerCase();
    const productos = leer("productos", []);
    let encontrados = 0;

    lista.innerHTML = "";

    for (let i = 0; i < productos.length; i++) {
        const p = productos[i];

        if (p.estado === "oculto") {
            continue;
        }

        if (p.nombre.toLowerCase().indexOf(texto) === -1) {
            continue;
        }

        let claseCorazon = "boton-corazon";
        if (esFavorito(p.id)) {
            claseCorazon = "boton-corazon activo";
        }

        let textoPrecio = dinero(p.precio);
        if (p.estado === "agotado") {
            textoPrecio = textoPrecio + " - Agotado";
        }

        lista.innerHTML += `
            <div class="column is-4">
                <div class="card producto-card" onclick="abrirProducto(${p.id})">
                    <div class="card-image">
                        <figure class="image is-4by5">
                            <img src="${p.imagen}" alt="${p.nombre}">
                        </figure>
                    </div>
                    <div class="card-content">
                        <div class="producto-encabezado">
                            <h2 class="producto-nombre">${p.nombre}</h2>
                            <button class="${claseCorazon}" onclick="favorito(event, ${p.id})">♥</button>
                        </div>
                        <p class="producto-descripcion">${textoPrecio}</p>
                    </div>
                </div>
            </div>
        `;

        encontrados++;
    }

    if (encontrados === 0) {
        lista.innerHTML = '<p class="subtitle" style="color: white;">No se encontraron productos</p>';
    }
}

function abrirProducto(id) {
    window.location.href = "producto.html?id=" + id;
}

function favorito(evento, id) {
    evento.stopPropagation();
    cambiarFavorito(id);
    mostrar();
}

cajaBusqueda.addEventListener("input", mostrar);
document.getElementById("botonBuscar").addEventListener("click", mostrar);

mostrar();