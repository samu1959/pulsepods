const formularioRegistro = document.getElementById("formRegistro");

formularioRegistro.addEventListener("submit", function (evento) {
    evento.preventDefault();

    const campos = formularioRegistro.elements;
    const nombre = campos.nombre.value.trim();
    const correo = campos.email.value.trim().toLowerCase();
    const password = campos.password.value;

    if (nombre === "" || correo === "" || password === "") {
        Swal.fire("Faltan datos", "Completa nombre, correo y contraseña", "warning");
        return;
    }

    if (password.length < 6) {
        Swal.fire("Contraseña corta", "Debe tener mínimo 6 caracteres", "warning");
        return;
    }

    const usuarios = leer("usuarios", []);

    for (let i = 0; i < usuarios.length; i++) {
        if (usuarios[i].correo === correo) {
            Swal.fire("Correo repetido", "Ya existe una cuenta con ese correo", "error");
            return;
        }
    }

    const nuevoUsuario = {
        nombre: nombre,
        correo: correo,
        password: password,
        fecha: campos.fecha.value,
        telefono: campos.telefono.value,
        departamento: campos.departamento.value,
        ciudad: campos.ciudad.value,
        tipoDocumento: campos.tipo_documento.value,
        documento: campos.documento.value,
        direccion: "",
        registro: new Date().toLocaleDateString("es-CO"),
        rol: "cliente"
    };

    usuarios.push(nuevoUsuario);
    guardar("usuarios", usuarios);

    Swal.fire("Listo", "Tu cuenta fue creada", "success").then(function () {
        window.location.href = "login.html";
    });
});