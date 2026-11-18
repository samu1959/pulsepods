

function leer(clave, valorPorDefecto) {
    try {
        const texto = localStorage.getItem(clave);
        if (texto === null) {
            return valorPorDefecto;
        }
        return JSON.parse(texto);
    } catch (e) {
        return valorPorDefecto;
    }
}

function guardar(clave, valor) {
    localStorage.setItem(clave, JSON.stringify(valor));
}

function esFavorito(id) {
    const favoritos = leer("favoritos", []);
    return favoritos.map(Number).includes(Number(id));
}

function cambiarFavorito(id) {
    id = Number(id);
    let favoritos = leer("favoritos", []).map(Number);

    if (favoritos.includes(id)) {
        favoritos = favoritos.filter(function (f) {
            return f !== id;
        });
    } else {
        favoritos.push(id);
    }

    guardar("favoritos", favoritos);
}

function dinero(valor) {
    return "$" + Number(valor).toLocaleString("es-CO");
}