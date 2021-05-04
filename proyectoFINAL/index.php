<?php

session_start();
if (isset($_POST['user'])) {
    echo  "iniciado sesion. Hola, " . $_SESSION['datosUsuario']['username'];
    echo "<script>console.log('test');</script>";
} else {
    echo "<script>console.log('test2');</script>";
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
        #formu {
            padding-top: 2%;
            margin: 0 auto;
            width: 60%;
        }

        #social {
            margin-top: 1em;
        }
    </style>

    <link rel="stylesheet" href="assets/css/login.css">
</head>

<body>

    <div id="social" class="row">
        <div class="col-md-9">Videoclub</div>
        <div class="col-md-3 row">

            <div class="col-md-6 botones">
                <input id="inicSesion" type="button" value="Iniciar Sesión" name="submit" class="btn btn-primary" />
            </div>
            <div class="col-md-6 botones">
                <input id="registro" type="button" value="Registrate" name="submit" class="btn btn-primary" />
            </div>



        </div>
    </div>
    <div id="formu" animation-delay="250" animation-type="fadeIn">
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
                                    <img src="assets/images/logo.png" alt="Aqui irá el logo cuando lo tenga" class="logo">
                                </div>
                                <p class="login-card-description">Inicia sesión en tu cuenta</p>
                                <form id="formuInicSesion" name="formuInicSesion" action="#!">
                                    <div class="form-group">
                                        <label for="user" class="sr-only">Usuario/Email</label>
                                        <input type="text" name="user" id="user" class="form-control" placeholder="Usuario123">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="password" class="sr-only">Contraseña</label>
                                        <input type="password" name="password" id="password" class="form-control" placeholder="***********">
                                    </div>
                                    <input name="login" id="login" class="btn btn-block login-btn mb-4" type="submit" value="Inicia sesión">
                                </form>
                                <a href="#!" class="forgot-password-link">¿Has olvidado tu contraseña?</a>
                                <p class="login-card-footer-text">¿No tienes cuenta? <a href="nuevoUsuario.php" class="text-reset">Registrate aquí</a></p>
                                <nav class="login-card-footer-nav">
                                    <a href="#!">Terminos de uso.</a>
                                    <a href="#!">Política de privacidad</a>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="js/ajax.js"></script>
<script src="js/jquery-3.4.1.min.js"></script>

<script>
    //Escondemos el formulario de primeras

    window.addEventListener("load", function(e) {
        $("#formu").hide();
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
        ajax("php/inicSesion.php", "POST", datos, function(e) {

        });
        $("#formuInicSesion")[0].reset();

    });
</script>

</html>