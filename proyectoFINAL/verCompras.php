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
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Film's Corner</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" id="inicio" href="#">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Explorar
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" id="verCatalogo" href="#">Ver catálogo</a>

                    </div>
                </li>
                <?php if (isset($_SESSION["datosUsuario"]) && $_SESSION["datosUsuario"]["tipo"] == "administrador") {
                ?>
                    <li class="nav-item dropdown" id="navbarAdministrador">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Administrador
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="registroPeliculas.php">Insertar película</a>
                            <a class="dropdown-item" href="#">Administrar préstamos</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Administrar usuarios</a>
                        </div>
                    </li>
                <?php
                }
                ?>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <?php
                if (isset($_SESSION["datosUsuario"])) {
                ?><ul class="navbar-nav mr-auto">
                        <li class="nav-item dropdown ">
                            <a class="nav-link btn-lg dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php echo $_SESSION["datosUsuario"]["userId"]; ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" id="misPrestamos" href="#">Añadir fondos</a>
                                <a class="dropdown-item" id="misPrestamos" href="verCompras.php">Mis préstamos</a>
                                <a class="dropdown-item" id="cerrarSesion" href="#">Cerrar sesión</a>
                                <a class="dropdown-item" id="eliminarCuenta" href="#">Eliminar cuenta</a>
                            </div>
                        </li>
                    </ul>
                <?php

                } else {

                ?><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalInicSesion">
                        Iniciar Sesión
                    </button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalRegistro">
                        Registrate
                    </button><?php
                            }
                                ?>

            </form>
        </div>
        <?php if (isset($_SESSION["datosUsuario"])) {
            echo '<div id="saldo" class="nav-link">Tu saldo: ' . $_SESSION["datosUsuario"]["cartera"] . '€</div>';
        } ?>

    </nav>

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


    <div class="modal fade" id="modalInicSesion" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="formu">
                        <main class="d-flex align-items-center min-vh-100 py-3 py-md-0">
                            <div class="container">
                                <div class="card login-card">
                                    <div class="row no-gutters">
                                        <div class="col-md-5">
                                            <img src="assets/images/introVideoclub.jpg" alt="login" class="login-card-img">

                                        </div>
                                        <div class="col-md-7">
                                            <div class="card-body">
                                                <div class="brand-wrapper">
                                                    <img src="#" alt="Aqui irá el logo cuando lo tenga" class="logo">
                                                </div>
                                                <p class="login-card-description">Inicia sesión en tu cuenta</p>
                                                <form id="formuInicSesion" name="formuInicSesion" action="#!">
                                                    <div class="form-group">
                                                        <label for="user" class="sr-only">Usuario/Email</label>
                                                        <input type="text" name="user" id="user" class="form-control" placeholder="Usuario/email">
                                                    </div>
                                                    <div class="form-group mb-4">
                                                        <label for="password" class="sr-only">Contraseña</label>
                                                        <input type="password" name="password" id="password" class="form-control" placeholder="***********">
                                                    </div>
                                                    <input name="login" id="login" class="btn btn-block login-btn mb-4" type="submit" value="Inicia sesión">
                                                </form>
                                                <a href="#!" class="forgot-password-link">¿Has olvidado tu contraseña?</a>
                                                <p class="login-card-footer-text">¿No tienes cuenta? <a href="nuevoUsuario.php" class="text-reset">Registrate aquí</a></p>
                                                <div id="coincidencia" class="alert alert-warning" role="alert">
                                                    El usuario y la contraseña no coinciden. Por favor, inténtalo de nuevo.
                                                </div>
                                                <nav class="login-card-footer-nav">
                                                    <a href="#!">Terminos de uso.</a>
                                                    <a href="privacyPolitics.html">Política de privacidad</a>
                                                </nav>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </main>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal de registro en la web -->
    <div class="modal fade" id="modalRegistro" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content ">
                <div class="modal-body">
                    <form id="formularioRegistro" class="form-horizontal" action='' method="POST">
                        <fieldset>
                            <div id="legend">
                                <legend class="">¡Bienvenido al videoclub!</legend>
                            </div>
                            <div class="control-group">
                                <!-- Username -->
                                <label class="control-label" for="usernameRegistro">Nombre de usuario</label>
                                <div class="controls">
                                    <input type="text" id="usernameRegistro" name="usernameRegistro" placeholder="Pepito123" class="input-xlarge" required>
                                    <p class="help-block">El usuario puede contener caracteres y números, sin espacios.</p>
                                </div>
                            </div>

                            <div class="control-group">
                                <!-- E-mail -->
                                <label class="control-label" for="emailRegistro">Email</label>
                                <div class="controls">
                                    <input type="email" id="emailRegistro" name="emailRegistro" placeholder="pepito123@gmail.com" class="input-xlarge" required>
                                    <p class="help-block">Por favor, introduce tu email</p>
                                </div>
                            </div>

                            <div class="control-group">
                                <!-- Password-->
                                <label class="control-label" for="passwordRegistro">Contraseña</label>
                                <div class="controls">
                                    <input type="password" id="passwordRegistro" name="passwordRegistro" placeholder="***********" class="input-xlarge" required>
                                    <p class="help-block">La contraseña debe tener al menos 4 caracteres</p>
                                </div>
                            </div>

                            <div class="control-group">
                                <!-- Password -->
                                <label class="control-label" for="password_confirmRegistro">Confirmar contraseña</label>
                                <div class="controls">
                                    <input type="password" id="password_confirmRegistro" name="password_confirmRegistro" placeholder="***********" class="input-xlarge" required>
                                    <p class="help-block">Por favor, confirma tu contraseña</p>
                                </div>
                            </div>
                            <div id="repetidos" class="alert alert-warning" role="alert">
                                El usuario o el email ya están registrados. Por favor, inténtalo de nuevo.
                            </div>
                            <div class="control-group">
                                <!-- Button -->
                                <div class="controls">
                                    <button id="insertarRegistro" class="btn btn-success">Registrate</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>

            </div>
        </div>
    </div>
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
    window.addEventListener("unload", function(e) {

    })

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
        location.href = "index.php";
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
            });
        }
    });
</script>


</html>