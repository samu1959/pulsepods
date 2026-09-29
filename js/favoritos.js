const contenedorFavoritos = document.getElementById("favoritos");
const mensajeVacio = document.getElementById("vacio");

function mostrar() {
    const productos = leer("productos", []);
    let total = 0;

    contenedorFavoritos.innerHTML = "";

    for (let i = 0; i < productos.length; i++) {
        const p = productos[i];

        if (esFavorito(p.id) === false) {
            continue;
        }

        contenedorFavoritos.innerHTML += `
            <div class="column is-4">
                <div class="card">
                    <div class="card-image">
                        <img src="${p.imagen}" alt="${p.nombre}">
                    </div>
                    <div class="card-content">
                        <h2 class="producto-nombre">${p.nombre}</h2>
                        <p class="producto-precio">${dinero(p.precio)}</p>
                        <p class="producto-descripcion">${p.descripcion}</p>
                        <div class="buttons mt-4">
                            <a href="../catalogo/producto.html?id=${p.id}" class="button">Ver producto</a>
                            <button class="button eliminar" onclick="quitar(${p.id})">Quitar</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        total++;
    }

    if (total === 0) {
        mensajeVacio.style.display = "block";
    } else {
        mensajeVacio.style.display = "none";
    }
}

function quitar(id) {
    cambiarFavorito(id);
    mostrar();
}

mostrar();