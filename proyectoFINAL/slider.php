<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/ajax.js"></script>
    <script src="assets/js/jquery-3.4.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <style>
    div#carouselExampleIndicators{
      width: 70%;
      height: 30%;
      border: 1px solid black;
      margin: 0 auto;
    }
    
    .carousel-inner{
      width:100%;
      max-height: 500px !important;
    }
    .carousel-item {
    width:100%;
    height:360px;
    }
    .bg-secondary{
      border-radius: 10px;
      opacity: 0.7;
    }
    
    </style>
</head>
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
 
  <div id="carouselPeliculas" class="carousel-inner">
    <div class="carousel-item active">
      <img src="assets\images\films\logofondo.jpg" class="d-block w-100 img-fluid" height="360px" alt="Fast and Furious">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Anterior</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Siguiente</span>
  </a>
</div>
</body>
<script>

   $(document).ready(function(e){
     //Llamamos a ajax y obtenemos todo de las peliculas.

     ajax("php/manejadorDB.php", "POST", {valor:"obtenerPeliculas"}, function(e){
       let arrayPeliculas = JSON.parse(e);
       console.log(arrayPeliculas);

       for (let indice = 0; indice < arrayPeliculas.length; indice++) {
                    $("#carouselPeliculas").append(`<div class="carousel-item">
      <img src="${arrayPeliculas[indice].imagen}" class="d-block w-100 img-fluid" height="360px" alt="">
      <div class="carousel-caption">
        <h5 class="bg-secondary">${arrayPeliculas[indice].nom_pelicula}</h5>
        <p class="bg-secondary"> ${arrayPeliculas[indice].genero_principal}. Año: ${arrayPeliculas[indice].anio}</p>
      </div>
      </div>`);
                                        
                }
     })
   });

</script>
</html>