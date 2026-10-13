exigirAdmin();

document.getElementById("cantidadProductos").textContent = leer("productos", []).length;
document.getElementById("cantidadPedidos").textContent = leer("pedidos", []).length;
document.getElementById("cantidadFavoritos").textContent = leer("favoritos", []).length;