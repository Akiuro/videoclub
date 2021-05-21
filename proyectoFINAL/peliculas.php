<div id="contenedorCartas" class="row row-cols-1 row-cols-md-3 g-4">
</div>


</body>
<script>
    //Una función al cargar la página, que nos cree todas las peliculas.

    $(window).on("load", function(e) {
        //Llamamos a Ajax, y obtenemos toda la información de las películas.

        ajax("php/manejadorDB.php", "POST", {
            valor: "obtenerPeliculas"
        }, function(e) {
            let misPeliculas = JSON.parse(e);
            //misPeliculas es un array. Ahora creamos de forma dinámica elementos y los agregamos al html.
            for (let indice = 0; indice < misPeliculas.length; indice++) {
                $("#contenedorCartas").append(`<div class="col">
                <div class="card">
                    <img src="${misPeliculas[indice].imagen}" class="card-img-top" alt="${misPeliculas[indice].nom_pelicula}">
                    <div class="card-body">
                        <h5 class="card-title">${misPeliculas[indice].nom_pelicula}</h5>
                        <p class="card-text">${misPeliculas[indice].sinopsis.substring(0, 180).concat('...')}</p>
                        <a href="#" class="btn btn-primary" data-id="${misPeliculas[indice].id}">Ver película</a>
                    </div>
                </div>
            </div>`);
            }
            for (let indice = 0; indice < misPeliculas.length; indice++) {
                $("#contenedorCartas").append(`<div class="col">
                <div class="card">
                    <img src="${misPeliculas[indice].imagen}" class="card-img-top" alt="${misPeliculas[indice].nom_pelicula}">
                    <div class="card-body">
                        <h5 class="card-title">${misPeliculas[indice].nom_pelicula}</h5>
                        <p class="card-text">${misPeliculas[indice].sinopsis.substring(0, 180).concat('...')}</p>
                        <a href="#" class="btn btn-primary" data-id="${misPeliculas[indice].id}">Ver película</a>
                    </div>
                </div>
            </div>`);
            }
            for (let indice = 0; indice < misPeliculas.length; indice++) {
                $("#contenedorCartas").append(`<div class="col">
                <div class="card">
                    <img src="${misPeliculas[indice].imagen}" class="card-img-top" alt="${misPeliculas[indice].nom_pelicula}">
                    <div class="card-body">
                        <h5 class="card-title">${misPeliculas[indice].nom_pelicula}</h5>
                        <p class="card-text">${misPeliculas[indice].sinopsis.substring(0, 180).concat('...')}</p>
                        <a href="#" class="btn btn-primary" data-id="${misPeliculas[indice].id}">Ver película</a>
                    </div>
                </div>
            </div>`);
            }
        });
    });
</script>

</html>