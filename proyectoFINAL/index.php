<?php

session_start();
if (isset($_POST['user'])) {
    echo  "iniciado sesion. Hola, " . $_SESSION['datosUsuario']['username'];
    echo "<script>console.log('Hay sesion');</script>";
} else {
    echo "<script>console.log('No hay sesion');</script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        #social {
            margin-top: 1em;
        }
    </style>

    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/ajax.js"></script>
    <script src="assets/js/jquery-3.4.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</head>

<body>

    <div id="social" class="row">
        <div class="col-md-9">Videoclub</div>
        <div class="col-md-3 row">

            <div class="col-md-6 botones">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalInicSesion">
                    Iniciar Sesión
                </button>
            </div>
            <div class="col-md-6 botones">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalRegistro">
                    Registrate
                </button>
            </div>
        </div>
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
        $("#repetidos").hide();
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

    })
</script>

</html>