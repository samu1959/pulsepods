const destacados = document.getElementById("destacados");
const productos = leer("productos", []);
let mostrados = 0;

for (let i = 0; i < productos.length; i++) {
    const p = productos[i];

    if (p.estado === "oculto" || mostrados === 3) {
        continue;
    }

    destacados.innerHTML += `
        <div class="column is-4">
            <div class="producto-card">
                <figure class="producto-imagen">
                    <img src="${p.imagen}" alt="${p.nombre}">
                </figure>
                <div class="producto-contenido">
                    <h3>${p.nombre}</h3>
                    <p>${p.descripcion}</p>
                    <a href="../catalogo/producto.html?id=${p.id}" class="button">Ver producto</a>
                </div>
            </div>
        </div>
    `;

    mostrados++;
}