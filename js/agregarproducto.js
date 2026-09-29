
exigirAdmin();

const formularioProducto = document.getElementById("formProducto");
const cajaMensaje = document.getElementById("mensaje");

formularioProducto.addEventListener("submit", function (evento) {
    evento.preventDefault();

    const productos = leer("productos", []);
    let nuevoId = 1;

    for (let i = 0; i < productos.length; i++) {
        if (productos[i].id >= nuevoId) {
            nuevoId = productos[i].id + 1;
        }
    }

    const nuevoProducto = {
        id: nuevoId,
        nombre: document.getElementById("nombre").value.trim(),
        precio: Number(document.getElementById("precio").value),
        stock: Number(document.getElementById("stock").value),
        descripcion: document.getElementById("descripcion").value.trim(),
        imagen: document.getElementById("imagen").value.trim(),
        categoria: document.getElementById("categoria").value,
        estado: document.getElementById("estado").value,
        modelo: false
    };

    productos.push(nuevoProducto);
    guardar("productos", productos);

    cajaMensaje.textContent = "El producto fue agregado correctamente";
    cajaMensaje.style.display = "block";
    formularioProducto.reset();
});