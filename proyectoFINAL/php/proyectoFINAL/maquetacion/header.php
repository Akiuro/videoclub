<style>
    div#contenedorCarousel {
        width: 100%;
        margin: 0 auto;
        padding-top: 10%;
    }

    .carousel-item {
        width: 100%;
        height: 800px;
    }

    .bg-secondary {
        border-radius: 10px;
        opacity: 0.7;
    }

    button#inicioToRegistro {
        background: none !important;
        border: none;
        padding: 0 !important;
        font-family: arial, sans-serif;
        color: #069;
        text-decoration: underline;
        cursor: pointer;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-light navbartop">
    <a class="navbar-brand" href="#"> &#127871 Film's Corner &#127871</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" id="inicio" href="index.php">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="verCatalogo" href="index.php">Ver catálogo</a>
            </li>

            </li>
            <?php if (isset($_SESSION["datosUsuario"]) && $_SESSION["datosUsuario"]["tipo"] == "administrador") {
            ?>
                <li class="nav-item dropdown" id="navbarAdministrador">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAdministrador" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Administrador
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownAdministrador">
                        <a class="dropdown-item" href="registroPeliculas.php">Insertar película</a>
                        <a class="dropdown-item" href="controlCompras.php">Administrar préstamos</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="controlUsuarios.php">Administrar usuarios</a>
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
                        <a class="nav-link btn-lg dropdown-toggle " href="#" id="navbarUsuario" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $_SESSION["datosUsuario"]["userId"]; ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarUsuario">
                            <a class="dropdown-item" id="aniadirFondos" href="" data-target="#modalRegistro">Añadir fondos</a>
                            <a class="dropdown-item" id="misPrestamos" href="verCompras.php">Mis préstamos</a>
                            <a class="dropdown-item" id="cerrarSesion" href="">Cerrar sesión</a>
                            <a class="dropdown-item" id="eliminarCuenta" href="">Eliminar cuenta</a>
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
    <div id="saldo_navbar"><?php if (isset($_SESSION["datosUsuario"])) {
                                echo '<div id="saldo" class="nav-link">Tu saldo: ' . $_SESSION["datosUsuario"]["cartera"] . '€</div>';
                            } ?></div>


</nav>


<div class="modal fade" id="modalInicSesion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div id="formu">
                    <main class="d-flex align-items-center py-3 py-md-0">
                        <div class="container">
                            <div class="card login-card">
                                <div class="row no-gutters">
                                    <div class="col-md-5">
                                        <img src="assets/images/introVideoclub.jpg" alt="login" class="login-card-img">

                                    </div>
                                    <div class="col-md-7">
                                        <div class="card-body">
                                            <div class="brand-wrapper">
                                                <p class="login-card-description">&#127871 Bienvenido a Film's Corner &#127871</p>
                                            </div>
                                            <p class="login-card-description">Inicia sesión en tu cuenta</p>
                                            <form id="formuInicSesion" name="formuInicSesion" action="#!">
                                                <div class="form-group">
                                                    <label for="user" class="sr-only">Usuario/Email</label>
                                                    <input type="text" name="user" id="user" class="form-control" placeholder="Usuario/email" autocomplete="off">
                                                </div>
                                                <div class="form-group mb-4">
                                                    <label for="password" class="sr-only">Contraseña</label>
                                                    <input type="password" name="password" id="password" class="form-control" placeholder="***********" >
                                                </div>
                                                <input name="login" id="login" class="btn btn-block login-btn mb-4" type="submit" value="Inicia sesión">
                                            </form>
                                            
                                            <div id="alertasLogIn" style="height: 10vh !important;">
                                                <div id="coincidencia" class="alert alert-warning" role="alert">
                                                    El usuario y la contraseña no coinciden. Por favor, inténtalo de nuevo.
                                                </div>
                                                <div id="baneado" class="alert alert-danger" role="alert">
                                                    Has sido baneado. Contacta con un administrador.
                                                </div>

                                            </div>

                                            <nav class="login-card-footer-nav">
                                                <a href="archivos_de_texto/terms.html">Terminos de uso.</a>
                                                <a href="archivos_de_texto/privacyPolitics.html">Política de privacidad</a>
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
                            <legend class="">¡Bienvenido a Film's Corner!</legend>
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
                                <input type="password" id="passwordRegistro" name="passwordRegistro" placeholder="***********" class="input-xlarge form-control" required>
                                <div class="invalid-feedback">
                                    Introduce tu contraseña.
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <!-- Password 2-->
                            <label class="control-label" for="password_confirmRegistro">Confirmar contraseña</label>
                            <div class="controls">
                                <input type="password" id="password_confirmRegistro" name="password_confirmRegistro" placeholder="***********" class="input-xlarge form-control" required>
                                <div class="invalid-feedback">
                                    Confirma tu contraseña.
                                </div>
                            </div>
                        </div>
                        <div id="alertasRegistro" style="height: 5vh;">
                            <div id="repetidos" class="alert alert-warning" role="alert">
                                El usuario o el email ya están registrados. Por favor, inténtalo de nuevo.
                            </div>
                            <div id="diffPassword" class="alert alert-warning" role="alert">
                                Las contraseñas no coinciden. Inténtalo de nuevo.
                            </div>
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

<!-- Modal -->
<div class="modal fade" id="modalSaldo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Insertar saldo en tu cuenta</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="login-card-description">Hola <?php echo $_SESSION["datosUsuario"]["userId"] ?>. Por favor, indica cuanto saldo quieres añadir a tu cuenta (en €).</p>
                <input type="number" name="saldoInsertar" id="saldoInsertar" class="form-control" placeholder="Ej: 14.95">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Esta vez no.
                </button>
                <button type="button" class="btn btn-primary" id="insertarSaldo">Insertar saldo</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalEliminarCuenta" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">¿Eliminar cuenta?</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="control-label"><?php echo $_SESSION["datosUsuario"]["userId"] ?>, ¿estás seguro de querer eliminar tu cuenta?.</p>
                <p class="control-label">Esta acción es permanente e irreversible, y perderás todo lo asociado a tu cuenta. ¿Estás seguro? Si es así, escribe "Eliminar"</p>
                <input type="text" name="escribeEliminar" id="escribeEliminar" class="form-control" placeholder='Escribe: Eliminar'>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="noEliminarCuenta" data-bs-dismiss="modal">
                    No quiero borrar mi cuenta.
                </button>
                <button type="button" class="btn btn-danger popover-test" id="eliminarCuentaPermanente" data-bs-content="No has escrito Eliminar correctamente. Revísalo.">Sí, eliminar cuenta permanentemente.</button>
            </div>
        </div>
    </div>
</div>

<script>
    //Escondemos el formulario de primeras

    window.addEventListener("load", function(e) {
        $("#coincidencia").hide();
        $("#catalogo").hide();
        $("#repetidos").hide();
        $("#baneado").hide();
        $("#diffPassword").hide();
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
        datos.nombre = $("#user").val();
        datos.password = $("#password").val();
        datos.valor = "iniciarSesion";
        ajax("php/manejadorDB.php", "POST", datos, function(e) {

            if (e == "Existe") {
                $('#modalInicSesion').modal('hide');
                location.reload();
            }
            if (e == "Baneado") {
                $("#baneado").fadeIn("slow");
                setTimeout(function() {
                    $("#baneado").fadeOut("slow");
                }, 5000);
            }
            if (e == "No existe" || e == "No hay usuario") {
                $("#coincidencia").fadeIn("slow");
                setTimeout(function() {
                    $("#coincidencia").fadeOut("slow");
                }, 5000);
            }
        });
        $("#formuInicSesion")[0].reset();

    });
    $("#formularioRegistro").on("submit", function(evento) {
        evento.preventDefault();

        //Lo primero es comprobar que todos los campos estén correctamente rellenados. Si es así, recojemos los datos.

        //Si las contraseñas no coinciden, vaciar los campos de contraseñas y pedir que se rellenen de nuevo.
        if ($("#passwordRegistro").val() != $("#password_confirmRegistro").val()) {
            $("#diffPassword").fadeIn("slow");
            setTimeout(function() {
                $("#diffPassword").fadeOut("slow");
            }, 5000);
            $('input[type="password"]').val('');

        } else {

            //Comprobamos si el usuario o el email ya existen.
            let usuario = new Object;
            usuario.user = $("#usernameRegistro").val();
            usuario.email = $("#emailRegistro").val();
            usuario.valor = "comprobarRepetido";

            ajax("php/manejadorDB.php", "POST", usuario, function(e) {

                if (e == 'Existe el user') {
                    $("#repetidos").fadeIn("slow");
            setTimeout(function() {
                $("#repetidos").fadeOut("slow");
            }, 5000);
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
                        location.reload();
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
        window.location.replace("index.php");
    });

    $("#aniadirFondos").on("click", function(e) {
        e.preventDefault();
        $("#modalSaldo").modal();
    });
    $("#insertarSaldo").on("click", function(e) {
        //Comprobamos posibles inserciones vacías o negativas en el saldo.
        if ($("#saldoInsertar").val() == "") {

        } else if ($("#saldoInsertar").val().slice(0, 1) == "-") {

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
                borrarCuenta.usuario = "<?php echo $_SESSION["datosUsuario"]["numericId"] ?>";
                ajax("php/manejadorDB.php", "POST", borrarCuenta, function(e) {

                });

                ajax("php/logout.php", "POST", {}, function(e) {
                    location.reload();
                });
            <?php } ?>
        } else {

        }
    });
</script>