exigirAdmin();

const listaPedidos = document.getElementById("listaPedidos");
const sinPedidos = document.getElementById("sinPedidos");
const estados = ["Pendiente", "Preparando", "Enviado", "Entregado"];

function mostrar() {
    const pedidos = leer("pedidos", []);

    listaPedidos.innerHTML = "";

    if (pedidos.length === 0) {
        sinPedidos.style.display = "block";
        return;
    }

    sinPedidos.style.display = "none";

    for (let i = 0; i < pedidos.length; i++) {
        const p = pedidos[i];
        let opciones = "";

        for (let j = 0; j < estados.length; j++) {
            let seleccionado = "";
            if (estados[j] === p.estado) {
                seleccionado = " selected";
            }
            opciones = opciones + "<option" + seleccionado + ">" + estados[j] + "</option>";
        }

        listaPedidos.innerHTML += `
            <div class="box panel mb-5">
                <div class="columns is-vcentered">
                    <div class="column">
                        <h2 class="title is-3">Pedido #${p.numero}</h2>
                        <p class="subtitulo">Cliente: ${p.cliente}</p>
                        <p class="subtitulo">Producto: ${p.nombre}</p>
                        <p class="subtitulo">Cantidad: ${p.cantidad}</p>
                        <p class="subtitulo">Total: ${dinero(p.precio * p.cantidad)}</p>
                        <p class="subtitulo">Fecha: ${p.fecha}</p>
                    </div>
                    <div class="column is-3">
                        <div class="select is-fullwidth">
                            <select onchange="cambiarEstado(${i}, this.value)">${opciones}</select>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
}

function cambiarEstado(posicion, nuevoEstado) {
    const pedidos = leer("pedidos", []);
    pedidos[posicion].estado = nuevoEstado;
    guardar("pedidos", pedidos);
}

mostrar();