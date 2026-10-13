

function bienvenida() {

    alert("¡Bienvenido a PulsePods! ");

}




function mostrarOferta() {

    alert(
        " Oferta especial \n\n" +
        "AirPods Pro 3\n" +
        "$84.900\n\n" +
        "¡Aprovecha nuestra promoción!"
    );

}



let productos = 6;


function mostrarProductos() {

    document.getElementById("cantidadProductos").textContent =
        productos + " productos disponibles";

}


function cambiarMensaje() {

    document.getElementById("mensaje").textContent =
        "Encuentra el accesorio perfecto para ti ";

}