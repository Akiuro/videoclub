<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Film's Corner</title>
    <style>

        body::-webkit-scrollbar {
            display: none; /* Con esto, escondemos las scrollbars, pero siguen funcionando. */
        }
        body {
            background-color: darkred !important;
            background: url('assets/images/cineBG.jpg') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            background-size: cover;
            -o-background-size: cover;
        }

        #social {
            margin-top: 1em;
        }

        #dcha {
            border: 1px solid red;
        }

        .ticket{
            margin-top: 2% !important;
            background: url('assets/images/BGticket.png');
            -webkit-background-size: cover;
            -moz-background-size: cover;
            background-size: cover;
            -o-background-size: cover;
            background-color: rgba(245, 245, 245, 0) !important;
        }
        .carta-peli{
            margin-top: 5% !important;
        }

    </style>

    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/ajax.js"></script>
    <script src="assets/js/jquery-3.4.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</head>

<body>
<div id="header" class=""><?php require_once "maquetacion/header.php" ?> </div>

<div id="underNAV" class="row">
        <div id="izda" class="col-2 p-3"></div>
        <div id="centro" class="col-8">
            <div id="inicioSlider"><?php require_once "slider.php" ?></div>
            <div id="catalogo"><?php require_once "peliculas.php" ?></div>
        </div>
        <div id="dcha" class="col-2"></div>
    </div>

    <!-- MODALES -->
    <div class="modal fade" id="modalVerPeli" tabindex="-1" aria-labelledby="modalVerPeli" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <!-- <div class="modal-header">
                    
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div> -->
                <div class="modal-body">
                    <p class="control-label">
                        <div class="card mb-3">
                            <div class="row g-0">
                            <div class="col-md-4">
                            <img id="imagenPeliculaModal" class="img-fluid img-thumbnail" src="" alt="pelicula">
                            </div>
                            <div class="col-md-8">
                            <div class="card-body">
                            <h5 class="modal-title" id="modal-title"></h5>
                            <h6 class="card-text" id="datosPeliculaModal"></h6>
                            <h6 class="card-text" id="sinopsisPeliculaModal"></h6>
                            <h6 class="card-text" id="precioPeliculaModal"></h6>
                            </div>
                            </div>
                        </div>
                        </div>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success popover-test " id="verMas" data-nombrepeli="test" data-bs-dismiss="modal">Comprar o alquilar</button>
                </div>
            </div>
        </div>
    </div>
</body>

<div id="footer"><?php require_once "maquetacion/footer.php" ?> </div> 

</html>

<script>
window.onload = function(){
     //Hacemos un bucle, mostrando las 4 ultimas peliculas solamente.

     ajax("php/manejadorDB.php", "POST", {valor:"obtenerPeliculas"}, function(e){
         let arrayPeliculas = JSON.parse(e);
         for (let indice = 0; indice < 5; indice++) {
            $("#izda").append(`<div class="card mb-1 shadow-lg p-3 mb-5 rounded ticket">
            <div class="row g-0">
            <div class="col-md-4">
            <img class ="img-fluid img-thumbnail" src="${arrayPeliculas[indice].imagen}" alt="pelicula">
            </div>
            <div class="col-md-8">
             <div class="card-body">
                <h5 class="card-title text-truncate">${arrayPeliculas[indice].nom_pelicula}</h5>
                <p class="card-text"> <a href="#" class="btn btn-primary" data-id="${arrayPeliculas[indice].id}">Ver más</a></p>
                <p class="card-text"><small class="text-muted">Año: ${arrayPeliculas[indice].anio},  ${arrayPeliculas[indice].genero_principal}</small></p>
            </div>
            </div>
        </div>
        </div>`);             
         }
     });

}

$("#inicio").on("click", function(e) {
        e.preventDefault();
        $("#inicioSlider").show();
        $("#catalogo").hide();
    });
    $("#verCatalogo").on("click", function(e) {
        e.preventDefault();
        $("#inicioSlider").hide();
        $("#catalogo").show();
    });

$("#izda").on("click", function(e){
    $target = $(e.target);
    if($target.data("id")!=undefined){
        //Cremamos un modal dinámico y lo llamamos.
        ajax("php/manejadorDB.php", "POST", {valor: "unaPelicula",
            id: $target.data("id")
        }, function(e){
            let miPelicula = JSON.parse(e);
            $("#modal-title").html(miPelicula[0].nom_pelicula);
            $("#imagenPeliculaModal").attr("src", miPelicula[0].imagen);
            $("#datosPeliculaModal").html("<p>Nombre original: "+miPelicula[0].nom_original+".</p><p> Año de publicación: "+miPelicula[0].anio+". </p><p>Géneros: "+miPelicula[0].genero_principal+", "+miPelicula[0].genero_secundario+".</p>");
            $("#sinopsisPeliculaModal").html("Sinopsis: "+miPelicula[0].sinopsis);
            $("#precioPeliculaModal").html("Precio: "+miPelicula[0].precio+"€");
            $("#verMas").data("nombrepeli", miPelicula[0].nom_pelicula);
            $('#modalVerPeli').modal('toggle');
        });
        
    }
});
$("#verMas").on("click", function(e){
    e.preventDefault();
    $('#modalVerPeli').modal('toggle');
    $("#busquedaPelis").val($("#verMas").data("nombrepeli"));
    $("#busquedaPelis").keyup();
    $("#verCatalogo").click();
});
    
</script>