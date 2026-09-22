


let usuarioGuardado = localStorage.getItem("usuario");

let usuario;

if (usuarioGuardado) {

    usuario = JSON.parse(usuarioGuardado);

} else {

  
    window.location.href = "login.html";
}




function cargarUsuario() {

    document.getElementById("nombreMenu").textContent =
        usuario.nombre;

    document.getElementById("correoMenu").textContent =
        usuario.correo;

    document.getElementById("nombrePerfil").textContent =
        usuario.nombre;

    document.getElementById("correoPerfil").textContent =
        usuario.correo;

    document.getElementById("nombreInput").value =
        usuario.nombre;

    document.getElementById("correoInput").value =
        usuario.correo;



    let inicial =
        usuario.nombre.charAt(0).toUpperCase();

    document.getElementById("inicialUsuario").textContent =
        inicial;

    document.getElementById("inicialPerfil").textContent =
        inicial;
}



function mostrarSeccion(nombreSeccion) {

    let secciones =
        document.querySelectorAll(".seccion");


    secciones.forEach(function(seccion) {

        seccion.classList.remove("activa");

    });


    document
        .getElementById(nombreSeccion)
        .classList.add("activa");


  

    document
        .getElementById("menuLateral")
        .classList.remove("mostrar");
}


function mostrarMenu() {

    document
        .getElementById("menuLateral")
        .classList.toggle("mostrar");
}



function guardarPerfil() {

    let nuevoNombre =
        document.getElementById("nombreInput").value;

    let nuevoCorreo =
        document.getElementById("correoInput").value;


    if (nuevoNombre === "" || nuevoCorreo === "") {

        alert("Por favor completa todos los campos.");

        return;
    }


    usuario.nombre = nuevoNombre;

    usuario.correo = nuevoCorreo;


   

    localStorage.setItem(
        "usuario",
        JSON.stringify(usuario)
    );


    cargarUsuario();


    alert("Los cambios se guardaron correctamente.");
}



let favoritos = [

    {
        id: 1,
        nombre: "AirPods Pro 3",
        precio: "$99.000",
        imagen: "🎧"
    },

    {
        id: 2,
        nombre: "Power Bank 10.000 mAh",
        precio: "$94.900",
        imagen: "🔋"
    },

    {
        id: 3,
        nombre: "Cargador USB-C 35W",
        precio: "$49.000",
        imagen: "🔌"
    }

];


function cargarFavoritos() {

    let contenedor =
        document.getElementById("listaFavoritos");


    contenedor.innerHTML = "";


    favoritos.forEach(function(producto) {

        contenedor.innerHTML += 

            <div class="producto">

                <div class="producto-imagen">

                    ${producto.imagen}

                </div>


                <div class="producto-info">

                    <button
                        class="corazon"
                        onclick="eliminarFavorito(${producto.id})">

                        

                    </button>


                    <h3>
                        ${producto.nombre}
                    </h3>


                    <p>
                        ${producto.precio}
                    </p>


                    <button
                        class="boton-principal"
                        onclick="verProducto(${producto.id})">

                        Ver producto

                    </button>

                </div>

            </div>

        







function eliminarFavorito(id) {

    favoritos =
        favoritos.filter(function(producto) {

            return producto.id !== id;

        });


    cargarFavoritos();
}



function verProducto(id) {

    alert(
        "Aquí puedes enviar al usuario a la página del producto."
    );
}



function cambiarModo() {

    let interruptor =
        document.getElementById("modoOscuro");


    if (interruptor.checked) {

        document.body.classList.add("oscuro");

        localStorage.setItem(
            "modoOscuro",
            "true"
        );

    } else {

        document.body.classList.remove("oscuro");

        localStorage.setItem(
            "modoOscuro",
            "false"
        );
    }
}




function cargarModo() {

    let modo =
        localStorage.getItem("modoOscuro");


    if (modo === "true") {

        document.body.classList.add("oscuro");

        document.getElementById(
            "modoOscuro"
        ).checked = true;
    }
}



function cambiarColor() {

    let color =
        document.getElementById("colorPrincipal").value;


    document.documentElement.style
        .setProperty("--principal", color);


    localStorage.setItem(
        "colorPrincipal",
        color
    );
}


function cargarColor() {

    let color =
        localStorage.getItem("colorPrincipal");


    if (color) {

        document.documentElement.style
            .setProperty("--principal", color);

        document.getElementById(
            "colorPrincipal"
        ).value = color;
    }
}



function guardarAjustes() {

    let activadas =
        document.getElementById(
            "notificaciones"
        ).checked;


    localStorage.setItem(
        "notificaciones",
        activadas
    );
}



function cambiarContrasena() {

    let nuevaContrasena =
        prompt("Escribe tu nueva contraseña:");


    if (nuevaContrasena === null) {
        return;
    }


    if (nuevaContrasena.length < 6) {

        alert(
            "La contraseña debe tener mínimo 6 caracteres."
        );

        return;
    }


    alert(
        "Contraseña actualizada correctamente."
    );
}



function eliminarCuenta() {

    let confirmar =
        confirm(
            "¿Seguro que quieres eliminar tu cuenta?"
        );


    if (confirmar) {

        localStorage.removeItem("usuario");

        alert(
            "Tu cuenta fue eliminada."
        );

        window.location.href =
            "login.html";
    }
}



function cerrarSesion() {

    let confirmar =
        confirm(
            "¿Quieres cerrar sesión?"
        );


    if (confirmar) {

        localStorage.removeItem("usuario");

        window.location.href =
            "login.html";
    }
}



cargarUsuario();

cargarFavoritos();

cargarModo();

cargarColor()
