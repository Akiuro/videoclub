<?php session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de compras</title>
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
        #body{
            padding-top:6vh;
        }
    </style>
</head>

<body>
    <div id="header" class=""><?php require_once "maquetacion/header.php" ?> </div>
    <div id="body">
        <div id="contenedor" class="row">
            <div class="col-1"></div>
            <div id="tablas" class="col-10 row">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Pelicula</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Compra/Alquiler</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Fecha de compra</th>
                            <th scope="col">Fecha fin</th>
                        </tr>
                    </thead>
                    <tbody id="comprasPeliculas">

                    </tbody>
                </table>
            </div>
            <div class="col-1"></div>
        </div>
    </div>
    <div id="footer" class="fixed-bottom"><?php require_once "maquetacion/footer.php" ?></div>

</body>

</html>
<script>
    window.onload = function(e) {
        ajax("php/manejadorDB.php", "POST", {
            valor: "todasVentas"
        }, function(e) {
            let arrayVentas = JSON.parse(e);
            arrayVentas.forEach((elemento, indice) => {
                $("#comprasPeliculas").append(`
                        <tr>
                            <th scope="row">${elemento.nombre_pelicula}</th>
                            <td>${elemento.cliente}</td>
                            <td>${elemento.tipo}</td>
                            <td>${elemento.precio}€</td>
                            <td>${elemento.fecha_inicio}</td>
                            <td>${elemento.fecha_fin}</td>
                        </tr>`);
            });
        });
    }
</script>