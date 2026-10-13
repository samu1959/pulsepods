exigirLogin();

const listaPedido = document.getElementById("pedidos");
const mensajeVacio = document.getElementById("vacio");
const contenidoPedido = document.getElementById("contenidoPedido");

function mostrar() {
    const carrito = leer("carrito", []);
    let total = 0;
    let unidades = 0;

    listaPedido.innerHTML = "";

    if (carrito.length === 0) {
        mensajeVacio.style.display = "block";
        contenidoPedido.style.display = "none";
        return;
    }

    mensajeVacio.style.display = "none";
    contenidoPedido.style.display = "block";

    for (let i = 0; i < carrito.length; i++) {
        const item = carrito[i];
        const subtotal = item.precio * item.cantidad;

        total = total + subtotal;
        unidades = unidades + item.cantidad;

        listaPedido.innerHTML += `
            <div class="pedido">
                <img class="pedido-imagen" src="${item.imagen}" alt="${item.nombre}">
                <div class="p-5">
                    <h3 class="pedido-nombre">${item.nombre}</h3>
                    <p class="pedido-precio">${dinero(item.precio)}</p>
                    <div class="cantidad my-3">
                        <strong>Cantidad</strong>
                        <div class="buttons has-addons mt-2">
                            <button class="button" onclick="cambiar(${i}, -1)">−</button>
                            <input class="input cantidad-input" value="${item.cantidad}" readonly>
                            <button class="button" onclick="cambiar(${i}, 1)">+</button>
                        </div>
                    </div>
                    <p class="pedido-subtotal">Subtotal: ${dinero(subtotal)}</p>
                    <button class="button eliminar mt-3" onclick="quitar(${i})">Quitar</button>
                </div>
            </div>
        `;
    }

    document.getElementById("totalProductos").textContent = unidades;
    document.getElementById("totalPedido").textContent = dinero(total);
    document.getElementById("fechaPedido").textContent = new Date().toLocaleDateString("es-CO");
}

function cambiar(posicion, valor) {
    const carrito = leer("carrito", []);
    const producto = buscarProducto(carrito[posicion].id);

    carrito[posicion].cantidad = carrito[posicion].cantidad + valor;

    if (carrito[posicion].cantidad < 1) {
        carrito[posicion].cantidad = 1;
    }

    if (producto !== null && carrito[posicion].cantidad > producto.stock) {
        carrito[posicion].cantidad = producto.stock;
    }

    guardar("carrito", carrito);
    mostrar();
}

function quitar(posicion) {
    const carrito = leer("carrito", []);
    carrito.splice(posicion, 1);
    guardar("carrito", carrito);
    mostrar();
}

function finalizarPedido() {
    const carrito = leer("carrito", []);
    const pedidos = leer("pedidos", []);
    const productos = leer("productos", []);
    const usuario = usuarioActual();

    for (let i = 0; i < carrito.length; i++) {
        const item = carrito[i];

        pedidos.push({
            numero: pedidos.length + 1,
            cliente: usuario.correo,
            nombre: item.nombre,
            precio: item.precio,
            cantidad: item.cantidad,
            estado: "Pendiente",
            fecha: new Date().toLocaleDateString("es-CO")
        });

        for (let j = 0; j < productos.length; j++) {
            if (productos[j].id === item.id) {
                productos[j].stock = productos[j].stock - item.cantidad;

                if (productos[j].stock <= 0) {
                    productos[j].stock = 0;
                    productos[j].estado = "agotado";
                }
            }
        }
    }

    guardar("pedidos", pedidos);
    guardar("productos", productos);
    guardar("carrito", []);

    alert("Tu pedido fue realizado correctamente");
    mostrar();
}

mostrar();