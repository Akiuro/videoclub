<div id="carouselExampleIndicators" class="carousel slide w-50" data-ride="carousel">

  <div id="carouselPeliculas" class="carousel-inner d-flex">
    <div class="carousel-item active">
      <img src="assets\images\films\logofondo.jpg" class="d-block w-100 rounded mx-auto" height="100%" alt="Videoclub">
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

<script>
  $(document).ready(function(e) {
    //Llamamos a ajax y obtenemos todo de las peliculas.

    ajax("php/manejadorDB.php", "POST", {
      valor: "obtenerPeliculas"
    }, function(e) {
      let arrayPeliculas = JSON.parse(e);

      for (let indice = 0; indice < arrayPeliculas.length; indice++) {
        $("#carouselPeliculas").append(`<div class="carousel-item">
      <img src="${arrayPeliculas[indice].imagen}" class="d-block w-100 rounded mx-auto" height="100%" alt="">
      <div class="carousel-caption">
        <h5 class="bg-secondary">${arrayPeliculas[indice].nom_pelicula}</h5>
        <p class="bg-secondary"> ${arrayPeliculas[indice].genero_principal}. Año: ${arrayPeliculas[indice].anio}</p>
      </div>
      </div>`);

      }
    })
  });
</script>

