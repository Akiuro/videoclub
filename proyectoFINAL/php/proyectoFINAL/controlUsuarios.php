<?php session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de usuarios</title>

    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/ajax.js"></script>
    <script src="assets/js/jquery-3.4.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <style>
        body::-webkit-scrollbar {
            display: none;
            /* Con esto, escondemos las scrollbars, pero siguen funcionando. */
        }
    </style>
</head>

<body>
    <div id="header" class=""><?php require_once "maquetacion/header.php" ?> </div>
    <div id="body">
        <div id="contenedorUsuarios" class="row">
            <div class="col-1"></div>
            <div id="tablas" class="col-10 row">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID usuario</th>
                            <th scope="col">Nombre de usuario</th>
                            <th scope="col">Gmail</th>
                            <th scope="col">Tipo de usuario</th>
                            <th scope="col">Banear usuario</th>
                            <th scope="col">Eliminar usuario</th>
                        </tr>
                    </thead>
                    <tbody id="administrarUsuarios">

                    </tbody>
                </table>
            </div>
            <div class="col-1"></div>
        </div>

        <!-- MODALES -->

        <div class="modal fade" id="modalEliminarCuenta2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">¿Eliminar cuenta?</h5>
                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="control-label">Esta acción es permanente e irreversible. ¿Realmente deseas eliminar esta cuenta?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="noEliminarCuenta" data-bs-dismiss="modal">
                            Esta vez no.
                        </button>
                        <button type="button" class="btn btn-danger popover-test" id="eliminarCuentaPermanente" data-borrar="test"> Sí, eliminar cuenta permanentemente.</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div id="footer" class="fixed-bottom"><?php require_once "maquetacion/footer.php" ?></div>

</body>
<script>
    window.onload = function(e) {
        ajax("php/manejadorDB.php", "POST", {
            valor: "mostrarUsuarios"
        }, function(e) {
            crearTablasUsuarios(JSON.parse(e));
        });


    }

    function crearTablasUsuarios(arrayUsuarios) {

        //Creamos todos los elementos de una tabla, y los añadimos de forma dinámica al html.
        arrayUsuarios.forEach((elemento, indice) => {

            //Hacemos comprobaciones para habilitar o deshabilitar el botón de banear.

            if (elemento.estado == "0") {
                baneado = "Baneado";
                color = "btn btn-danger";
            } else {
                baneado = "Banear";
                color = "btn btn-dark";
            }
            //Insertamos el elemento en la tabla.
            $("#administrarUsuarios").append(`<tr>
                            <th scope="row">${elemento.id}</th>
                            <td>${elemento.nom_usuario}</td>
                            <td>${elemento.email}</td>
                            <td>${elemento.tipo_usuario}</td>
                            <td><button data-banear="${elemento.id}"  class="${color}">${baneado}</button></td>
                            <td><button data-eliminar="${elemento.id}" class="btn btn-dark">Eliminar</button></td>
                        </tr>`);
        });
    }

    $("#administrarUsuarios").on("click", function(e) {

        $target = $(e.target);
        //Añadimos funcionalidad a los botones de banear y de eliminar.

        if ($target.data('banear') != undefined) {
            if ($target.html() == "Baneado") {
                //Si el usuario ya está baneado, se le desbaneará.
                $target.html("Banear");
                $target.removeClass("btn btn-danger");
                $target.addClass("btn btn-dark");


            } else {
                //Si no, se le banea.
                $target.html("Baneado");
                $target.removeClass("btn btn-dark");
                $target.addClass("btn btn-danger");
            }
            ajax("php/manejadorDB.php", "POST", {
                valor: "banear",
                id_usuario: $target.data('banear')
            }, function(e) {});
        }
        if ($target.data('eliminar') != undefined) {
            //Añadimos al boton de eliminar el id del usuario, el cual se encuentra en data-eliminar
            $("#eliminarCuentaPermanente").data("borrar", $target.data('eliminar'));
            $("#modalEliminarCuenta2").modal();

        }
    });

    $("#eliminarCuentaPermanente").on("click", function(e) {
        $target = $(e.target);
        let borrarCuenta = new Object();
        borrarCuenta.valor = "eliminarUsuario";
        borrarCuenta.usuario = $target.data("borrar");
        ajax("php/manejadorDB.php", "POST", borrarCuenta, function(e) {
            location.reload();
        });

    });
</script>

</html>