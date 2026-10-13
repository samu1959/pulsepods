const usuario = usuarioActual();

function cerrarSesion() {
    localStorage.removeItem("usuario");
    window.location.href = "../login/login.html";
}

if (usuario !== null) {
    document.getElementById("tituloCuenta").textContent = "Hola, " + usuario.nombre;
    document.getElementById("mensajeCuenta").textContent = usuario.correo;

    let botones = "";

    if (usuario.rol === "admin") {
        botones = '<a href="../admin/cuentaAdmin.html" class="button boton-principal">Panel de administrador</a>';
    }

    botones = botones + '<button class="button boton-secundario" onclick="cerrarSesion()">Cerrar sesión</button>';
    document.getElementById("botonesCuenta").innerHTML = botones;
}