exigirAdmin();

const listaProductos = document.getElementById("listaProductos");
const sinProductos = document.getElementById("sinProductos");

function mostrar() {
    const productos = leer("productos", []);

    listaProductos.innerHTML = "";

    if (productos.length === 0) {
        sinProductos.style.display = "block";
        return;
    }

    sinProductos.style.display = "none";

    for (let i = 0; i < productos.length; i++) {
        const p = productos[i];

        listaProductos.innerHTML += `
            <div class="column is-4">
                <div class="box panel">
                    <h2 class="title is-4">${p.nombre}</h2>
                    <p class="subtitulo">${p.descripcion}</p>
                    <p class="subtitulo mt-4">
                        <strong style="color:#F5A623;">Precio:</strong> ${dinero(p.precio)}
                    </p>
                    <p class="subtitulo">
                        <strong style="color:#F5A623;">Stock:</strong> ${p.stock}
                    </p>
                    <p class="subtitulo">
                        <strong style="color:#F5A623;">Estado:</strong> ${p.estado}
                    </p>
                    <button class="button boton-secundario is-fullwidth mt-5" onclick="eliminar(${i})">
                        Eliminar producto
                    </button>
                </div>
            </div>
        `;
    }
}

function eliminar(posicion) {
    if (confirm("¿Seguro que quieres eliminar este producto?") === false) {
        return;
    }

    const productos = leer("productos", []);
    productos.splice(posicion, 1);
    guardar("productos", productos);
    mostrar();
}

mostrar();