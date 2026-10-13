exigirLogin();

const usuario = usuarioActual();
const correoAnterior = usuario.correo;

function textoODefecto(valor) {
    if (valor) {
        return valor;
    }
    return "No registrado";
}

if (document.getElementById("dNombre")) {
    let apellido = "";
    if (usuario.apellido) {
        apellido = usuario.apellido;
    }

    document.getElementById("dNombre").textContent = usuario.nombre + " " + apellido;
    document.getElementById("dCorreo").textContent = usuario.correo;
    document.getElementById("dTelefono").textContent = textoODefecto(usuario.telefono);
    document.getElementById("dDireccion").textContent = textoODefecto(usuario.direccion);
    document.getElementById("dCiudad").textContent = textoODefecto(usuario.ciudad);
    document.getElementById("dFecha").textContent = textoODefecto(usuario.registro);
}

if (document.getElementById("guardar")) {
    const campos = ["nombre", "apellido", "correo", "telefono", "direccion", "ciudad", "departamento", "postal"];

    for (let i = 0; i < campos.length; i++) {
        const valor = usuario[campos[i]];
        if (valor) {
            document.getElementById(campos[i]).value = valor;
        }
    }

    document.getElementById("guardar").addEventListener("click", function () {
        const nombre = document.getElementById("nombre").value.trim();
        const correo = document.getElementById("correo").value.trim().toLowerCase();
        const usuarios = leer("usuarios", []);

        if (nombre === "" || correo === "") {
            alert("El nombre y el correo son obligatorios");
            return;
        }

        for (let i = 0; i < usuarios.length; i++) {
            if (usuarios[i].correo === correo && correo !== correoAnterior) {
                alert("Ese correo ya está registrado");
                return;
            }
        }

        for (let i = 0; i < campos.length; i++) {
            usuario[campos[i]] = document.getElementById(campos[i]).value.trim();
        }
        usuario.correo = correo;

        const metodo = document.querySelector('input[name="metodoEntrega"]:checked');
        if (metodo) {
            usuario.metodoEntrega = metodo.value;
        }

        for (let i = 0; i < usuarios.length; i++) {
            if (usuarios[i].correo === correoAnterior) {
                usuarios[i] = usuario;
            }
        }

        guardar("usuarios", usuarios);
        guardar("usuario", usuario);

        alert("Tus datos fueron guardados");
        window.location.href = "datos.html";
    });
}