<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis compras</title>
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
                    <h2>Hola, <?php
                                if (isset($_SESSION["datosUsuario"]["userId"])) {
                                    echo $_SESSION["datosUsuario"]["userId"];
                                };
                                ?>. Aquí están todas tus acciones.</h2>
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
    <div id="footer" class="fixed-bottom"><?php require_once "maquetacion/footer.php" ?> </div>




</body>
<script>
    //Escondemos el formulario de primeras

    window.addEventListener("load", function(e) {

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