<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    </style>
</head>

<link rel="stylesheet" href="assets/css/login.css">
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<script src="assets/js/ajax.js"></script>
<script src="assets/js/jquery-3.4.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<body>
<div id="header" class=""><?php require_once "maquetacion/header.php" ?> </div>
<div id="midpage">
<div id="contenedor" class="row">
        <div class="col-1"></div>
        <div id="tablas" class="col-10 row">
            <div id="saludar" class="col">
                <h2>Hola, <?php echo $_SESSION["datosUsuario"]["userId"]; ?>. Aquí están todas tus acciones.</h2>
            </div>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Pelicula</th>
                        <th scope="col">Compra/Alquiler</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Fecha de compra</th>
                        <th scope="col">Fecha fin</th>
                        <th scope="col">Devolver</th>
                    </tr>
                </thead>
                <tbody id="comprasPeliculas">

                </tbody>
            </table>
        </div>
        <div class="col-1"></div>
    </div>
</div>
<div id="footer"class="fixed-bottom"><?php require_once "maquetacion/footer.php" ?> </div> 

    


</body>
<script>
    //Escondemos el formulario de primeras

    window.addEventListener("load", function(e) {
        $("#coincidencia").hide();
        $("#catalogo").hide();
        $("#repetidos").hide();

        //Cuando se cargue esta página, se obtiene tu nombre de usuario. Se mostrarán absolutamente todos los alquileres a tu nombre.
        let nombreUsuario = "<?php echo $_SESSION["datosUsuario"]["userId"]; ?>";

        //Hacemos llamada a ajax y obtenemos todos los préstamos/compras a nombre del usuario.
        let datosPasar = new Object;
        datosPasar.valor = "mostrarVentas";
        datosPasar.usuario = nombreUsuario;
        ajax("php/manejadorDB.php", "POST", datosPasar, function(e) {
            let ventas = JSON.parse(e);
            if (ventas.length == 0) {
                $("#comprasPeliculas").append(`
                       <h1>No has realizado ni compras ni alquileres con esta cuenta.</h1>`);
            } else {
                let fecha_fin = "";
                let disabled = "";
                let devolver = "Devolver";
                ventas.forEach((elemento, indice) => {
                    //Este if comprueba si es una compra o un alquiler. Dependiendo del caso, mostrará fecha o no.
                    if (elemento.tipo == "compra") {
                        fecha_fin = "No hay fecha límite";
                    } else {
                        fecha_fin = elemento.fecha_fin;
                    }
                    //Este if comprobará si el elemento ya está devuelto. Si lo está, deshabilitará el botón.
                    if (elemento.devuelto == "Si") {
                        disabled = "disabled='disabled'";
                        devolver = "Devuelto";
                    } else {
                        disabled = "";
                        devolver = "Devolver";
                    }
                    $("#comprasPeliculas").append(`
                        <tr>
                            <th scope="row">${elemento.nombre_pelicula}</th>
                            <td>${elemento.tipo}</td>
                            <td>${elemento.precio}€</td>
                            <td>${elemento.fecha_inicio}</td>
                            <td>${fecha_fin}</td>
                            <td><button data-devolver="${elemento.id_prestamo}" ${disabled} class="btn btn-dark">${devolver}</button></td>
                        </tr>`);
                });
            }

        });



    });

    $(document).ready(function() {
        $('#comprasPeliculas').DataTable();
        $('.dataTables_length').addClass('bs-select');
    });

    $("#inicSesion").on("click", function(e) {
        $("#formu").toggle();
    });

    //Añadimos funcionalidad al formulario. Recogerá los datos, y mediante una llamada AJAX accederá a la base de datos, iniciando así sesión.
    $("#formuInicSesion").on("submit", function(e) {
        e.preventDefault();
        //Creamos un objeto datos con todo lo que va a pasarse
        let datos = new Object;
        datos.user = $("#user").val();
        datos.password = $("#password").val();
        datos.valor = "iniciarSesion";
        ajax("php/manejadorDB.php", "POST", datos, function(e) {

            if (e == "Existe") {
                $("#coincidencia").hide();
                $('#modalInicSesion').modal('hide');
                location.reload();
            }
            if (e == "No existe") {
                $("#coincidencia").show();

            }
        });
        $("#formuInicSesion")[0].reset();

    });
    $("#formularioRegistro").on("submit", function(evento) {
        evento.preventDefault();

        //Lo primero es comprobar que todos los campos estén correctamente rellenados. Si es así, recojemos los datos.

        //Si las contraseñas no coinciden, vaciar los campos de contraseñas y pedir que se rellenen de nuevo.
        if ($("#passwordRegistro").val() != $("#password_confirmRegistro").val()) {
            console.log("no son iguales");
            $('input[type="password"]').val('');

        } else {

            //Comprobamos si el usuario o el email ya existen.
            let usuario = new Object;
            usuario.user = $("#usernameRegistro").val();
            usuario.email = $("#emailRegistro").val();
            usuario.valor = "comprobarRepetido";

            ajax("php/manejadorDB.php", "POST", usuario, function(e) {

                if (e == 'Existe el user') {
                    $("#repetidos").show();
                }
                if (e == 'No existe el user') {

                    let nombre = $("#usernameRegistro").val();
                    let email = $("#emailRegistro").val();
                    let password = $("#passwordRegistro").val();

                    //Creamos un objeto y lo enviamos mediante ajax. Con esto, buscaremos crear un nuevo usuario en la base de datos.

                    let nuevoUsuario = new Object;
                    nuevoUsuario.nombre = nombre;
                    nuevoUsuario.email = email;
                    nuevoUsuario.password = password;
                    nuevoUsuario.valor = 'registroUsuario';

                    ajax("php/manejadorDB.php", "POST", nuevoUsuario, function(e) {
                        $("#formularioRegistro")[0].reset();
                    });
                    $('#modalRegistro').modal('hide');
                    $("#repetidos").hide();
                }
            });
            //Al acabar, destruimos las variables para que no de errores.

        }

    });
    $("#cerrarSesion").on("click", function(e) {
        e.preventDefault();
        ajax("php/logout.php", "POST", "", function(e) {});
        location.reload();
    });

    $("#inicioToRegistro").on("click", function(e) {
        $('#modalInicSesion').modal('hide');
    });

    $("#inicio").on("click", function(e) {
        $("#inicioSlider").show();
        $("#catalogo").hide();
    });
    $("#verCatalogo").on("click", function(e) {
        $("#inicioSlider").hide();
        $("#catalogo").show();
    });
    $("#aniadirFondos").on("click", function(e) {
        e.preventDefault();
        $("#modalSaldo").modal();
    });
    $("#insertarSaldo").on("click", function(e) {
        if ($("#saldoInsertar").val() == "") {
            console.log("llenalo puto!");
        } else if ($("#saldoInsertar").val().slice(0, 1) == "-") {
            console.log("negativos no puto!");
        } else {
            let insertarSaldo = new Object;
            insertarSaldo.valor = "ingresarDinero";
            insertarSaldo.ingreso = $("#saldoInsertar").val();
            ajax("php/manejadorDB.php", "POST", insertarSaldo, function(e) {});
            location.reload();
        }
    });
    $("#eliminarCuenta").on("click", function(e) {
        e.preventDefault();
        $('#modalEliminarCuenta').modal();
    });
    $("#noEliminarCuenta").on("click", function(e) {
        e.preventDefault();
        $('#modalEliminarCuenta').modal('hide');
    });
    $("#eliminarCuentaPermanente").on("click", function(e) {
        if ($("#escribeEliminar").val() == "Eliminar") {
            e.preventDefault();
            <?php if (isset($_SESSION["datosUsuario"]["userId"])) { ?>
                let borrarCuenta = new Object();
                borrarCuenta.valor = "eliminarUsuario";
                borrarCuenta.usuario = "<?php echo $_SESSION["datosUsuario"]["userId"] ?>";
                ajax("php/manejadorDB.php", "POST", borrarCuenta, function(e) {

                });

                ajax("php/logout.php", "POST", {}, function(e) {
                    location.reload();
                });
            <?php } ?>
        } else {

        }
    });

    //Para cuando se haga click en devolver, controlamos dónde se ha hecho click, y actualizamos.
    $("#comprasPeliculas").on("click", function(e) {
        $target = $(e.target);
        if ($target.data('devolver') != undefined) {

            let datosDevolucion = new Object;
            datosDevolucion.valor = "devolver";
            datosDevolucion.id_prestamo = $target.data('devolver');
            //Hacemos la devolución por ajax.
            ajax("php/manejadorDB.php", "POST", datosDevolucion, function(e) {
                //Deshabilitamos el botón para que no pueda devolverse algo de nuevo.
                $target.attr('disabled', 'disabled');
                $target.html("Devuelto");
                location.reload();
            });
        }
    });
</script>


</html>