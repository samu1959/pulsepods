const formularioLogin = document.getElementById("formLogin");

formularioLogin.addEventListener("submit", function (evento) {
    evento.preventDefault();

    const correo = document.getElementById("correo").value.trim().toLowerCase();
    const password = document.getElementById("password").value;
    const usuarios = leer("usuarios", []);

    for (let i = 0; i < usuarios.length; i++) {
        if (usuarios[i].correo === correo && usuarios[i].password === password) {
            guardar("usuario", usuarios[i]);

            if (usuarios[i].rol === "admin") {
                window.location.href = "../admin/cuentaAdmin.html";
            } else {
                window.location.href = "../inicio/index.html";
            }
            return;
        }
    }

    Swal.fire("Error", "Correo o contraseña incorrectos", "error");
});