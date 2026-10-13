const casillas = document.querySelectorAll(".checkbox input");
const guardadas = leer("notificaciones", null);

if (guardadas !== null) {
    for (let i = 0; i < casillas.length; i++) {
        casillas[i].checked = guardadas[i];
    }
}

document.getElementById("guardar").addEventListener("click", function () {
    const valores = [];

    for (let i = 0; i < casillas.length; i++) {
        valores.push(casillas[i].checked);
    }

    guardar("notificaciones", valores);
    alert("Configuración guardada");
});