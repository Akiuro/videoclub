<form class="bd-search position-relative me-auto">
    <span class="algolia-autocomplete" style="position: relative; display: inline-block; direction: ltr;">
        <input type="search" class="form-control ds-input" id="busquedaPelis" placeholder="Buscar peliculas..." aria-label="Byscar peliculas..." autocomplete="off" data-bd-docs-version="5.0" spellcheck="false" role="combobox" aria-autocomplete="list" aria-expanded="false" aria-owns="algolia-autocomplete-listbox-0" dir="auto" style="position: relative; vertical-align: top;">
    </span>
    </span>
</form>
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
            insertarCartas(misPeliculas);
        });
    });

    $("#busquedaPelis").keyup(function(e) {
        let miBusqueda = $("#busquedaPelis").val();
        //Lo primero es vaciar lo anterior para que no haya errores de duplicidad.
        $("#contenedorCartas").html("");


        ajax("php/manejadorDB.php", "POST", {
            valor: "obtenerPeliculas"
        }, function(e) {
            let misPeliculas = JSON.parse(e);
            //Ahora comprobamos. Si la barra de busqueda está vacia lo imprime todo, si no, solo lo que está en la barra.
            if (miBusqueda == "") {
                insertarCartas(misPeliculas);
            } else {
                //Filtramos la busqueda por lo que haya en la barra de navegación, creando de forma dinámica los elementos.
                for (let indice = 0; indice < misPeliculas.length; indice++) {
                    if (misPeliculas[indice].nom_pelicula.search(miBusqueda) != -1) {
                        insertarCartaIndividual(misPeliculas, miBusqueda);
                    } else {

                    }
                }
            }
        });
    });
    //Con este manejador, registraremos el click cuando se haga en los elementos de búsqueda.
    //Dependiendo de si se hace en un tipo de botón u otro, sucederán distintas cosas.

    $('#contenedorCartas').on('click', function(e) {
        $target = $(e.target);
        if ($target.data('id') != undefined) {

            let peliculaComprar = new Object();
            peliculaComprar.valor = "unaPelicula";
            peliculaComprar.id = $target.data('id');

            ajax("php/manejadorDB.php", "POST", peliculaComprar, function(e) {

                let peliculaObtenida = JSON.parse(e);
                console.log(peliculaObtenida);

            });

        }
    });

    function insertarCartas(misPeliculas) {
        for (let indice = 0; indice < misPeliculas.length; indice++) {
            $("#contenedorCartas").append(`<div class="col">
                        <div class="card">
                            <img src="${misPeliculas[indice].imagen}" class="card-img-top" alt="${misPeliculas[indice].nom_pelicula}">
                            <div class="card-body">
                                <h5 class="card-title">${misPeliculas[indice].nom_pelicula}</h5>
                                <p class="card-text">Géneros: ${misPeliculas[indice].genero_principal}, ${misPeliculas[indice].genero_secundario}</p>
                                <p class="card-text">${misPeliculas[indice].sinopsis.substring(0, 180).concat('...')}</p>
                                <p class="card-text">Precio: ${misPeliculas[indice].precio}€</p>
                                <a href="#" class="btn btn-primary" data-id="${misPeliculas[indice].id}">Comprar película</a>
                                <a href="#" class="btn btn-primary" data-id="${misPeliculas[indice].id}">Alquilar película</a>
                            </div>
                        </div>
                    </div>`);
        }
    }

    function insertarCartaIndividual(misPeliculas, miBusqueda) {
        misPeliculas.forEach((elemento, indice) => {
            if (elemento.nom_pelicula.search(miBusqueda) != -1) {
                $("#contenedorCartas").append(`<div class="col">
                        <div class="card">
                            <img src="${elemento.imagen}" class="card-img-top" alt="${elemento.nom_pelicula}">
                            <div class="card-body">
                                <h5 class="card-title">${elemento.nom_pelicula}</h5>
                                <p class="card-text">Géneros: ${elemento.genero_principal}, ${elemento.genero_secundario}</p>
                                <p class="card-text">${elemento.sinopsis.substring(0, 180).concat('...')}</p>
                                <p class="card-text">Precio: ${misPeliculas[indice].precio}€</p>
                                <a href="#" class="btn btn-primary" data-id="${elemento.id}" data-comprar="yes">Comprar película</a>
                                <a href="#" class="btn btn-primary" data-id="${misPeliculas[indice].id}" data-alquilar="yes">Alquilar película</a>
                            </div>
                        </div>
                    </div>`);
            }
        });
    }
</script>

</html>