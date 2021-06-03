<div id="noStock" class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>¡No hay existencias!</strong> Parece que no hay existencias de esa película ahora mismo, contacta con un administrador.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div id="masAlquiler" class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>¡Holy guacamoly!</strong> Ya tienes una película en alquiler. Por favor, cumple tu plazo o devuelve la anterior para alquilar una nueva.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div id="noDinero" class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>¡Holy guacamoly!</strong> ¡No hay dinero suficiente, añade algo más!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div id="siDinero" class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>¡Holy guacamoly!</strong> ¡Enhorabuena, has adquirido un nuevo producto!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div id="noInicSesion" class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>¡Hey, usuario!</strong> Necesitas haber iniciado sesión antes de comprar o alquilar cualquier cosa.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div id="tituloVentanaPelis">
    <h1 style="color: white; text-align: center; margin: 3%;">🎬 Todas las películas 🎬</h1>
</div>
<form class="bd-search position-relative me-auto">
    <span class="algolia-autocomplete" style="position: relative; display: inline-block; direction: ltr;">
        <input type="search" class="form-control ds-input" id="busquedaPelis" placeholder="Buscar peliculas..." aria-label="Buscar peliculas..." autocomplete="off" data-bd-docs-version="5.0" spellcheck="false" role="combobox" aria-autocomplete="list" aria-expanded="false" aria-owns="algolia-autocomplete-listbox-0" dir="auto" style="position: relative; vertical-align: top;">
    </span>
    </span>
</form>
<div id="contenedorCartas" class="row row-cols-1 row-cols-md-4 g-4">
</div>

</body>
<script>
    //Una función al cargar la página, que nos cree todas las peliculas.

    $(window).on("load", function(e) {
        $("#noDinero").hide();
        $("#siDinero").hide();
        $("#noStock").hide();
        $("#masAlquiler").hide();
        $("#noInicSesion").hide();
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
                for (let indice = 0; indice < misPeliculas.length; indice++ && $("#contenedorCartas").html() == "") {
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
            //Comprobamos si el usuario ha iniciado sesión. Si no lo ha hecho, se le indicará que debe hacerlo para poder comprar/alquilar.
            <?php if (isset($_SESSION["datosUsuario"])) { ?>

                let comprar_alquilar = "";
                let noAlquila = false;
                if ($target.data('comprar') != undefined) {
                    comprar_alquilar = "compra";
                    realizarVenta($target, comprar_alquilar);
                }
                if ($target.data('alquilar') != undefined) {
                    comprar_alquilar = "alquiler";
                    //Hemos de comprobar si el usuario tiene una película alquilada. Si es así, no podrá alquilar nada.
                    let comprobarAlquileres = new Object();
                    comprobarAlquileres.valor = "mostrarVentas";
                    comprobarAlquileres.usuario = "<?php echo $_SESSION["datosUsuario"]["userId"] ?>";
                    ajax("php/manejadorDB.php", "POST", comprobarAlquileres, function(e) {
                        let arrayAlquileres = JSON.parse(e);
                        for (let indice = 0; indice < arrayAlquileres.length; indice++) {
                            if (arrayAlquileres[indice].devuelto == "No" && arrayAlquileres[indice].tipo == "alquiler") {
                                noAlquila = true;
                            } else {

                            }
                        }
                        //Comprobamos si se dio el caso.
                        if (noAlquila == true) {
                            $("#masAlquiler").fadeIn("slow");
                            setTimeout(function() {
                                $("#noDinero").fadeOut("slow");
                            }, 5000);
                        } else {
                            realizarVenta($target, comprar_alquilar);
                        }


                    });
                }

            <?php } else { ?>
                $("#noInicSesion").fadeIn("slow");
                setTimeout(function() {
                    $("#noInicSesion").fadeOut("slow");
                }, 5000);
            <?php } ?>


        }
    });

    function realizarVenta($target, comprar_alquilar) {
        <?php if (isset($_SESSION["datosUsuario"])) { ?>
            let peliculaAccion = new Object();
            peliculaAccion.valor = "unaPelicula";
            peliculaAccion.id = $target.data('id');

            ajax("php/manejadorDB.php", "POST", peliculaAccion, function(e) {
                let peliculaObtenida = JSON.parse(e);

                //Una vez comprobado, comprobamos si hay stock de la pelicula en cuestión. Si la hay, se ejecutará la acción, si no, se avisará al usuario.
                $stockDisponible = peliculaObtenida[0].cantidad_disponible;
                if ($stockDisponible >= 1) {
                    //Creamos un objeto venta, se lo pasamos al servidor, ejecutará la venta y se registrará en la base de datos.
                    let miVenta = new Object();
                    miVenta.valor = "vender";
                    miVenta.nom_pelicula = peliculaObtenida[0].nom_pelicula;
                    miVenta.tipo = comprar_alquilar;
                    miVenta.precio = peliculaObtenida[0].precio;
                    ajax("php/manejadorDB.php", "POST", miVenta, function(e) {
                        if (e == "No hay dinero") {
                            $("#noDinero").fadeIn("slow");
                            setTimeout(function() {
                                $("#noDinero").fadeOut("slow");
                            }, 5000);
                        } else {
                            //Actualizamos el navbar
                            $("#saldo").html("<?php echo 'Tu saldo: ' . $_SESSION["datosUsuario"]["cartera"] . '€' ?>");

                            $("#siDinero").fadeIn("slow");
                            setTimeout(function() {
                                $("#siDinero").fadeOut("slow");
                            }, 5000);
                        }
                    });
                } else {
                    $("#noStock").fadeIn("slow");
                    setTimeout(function() {
                        $("#noStock").fadeOut("slow");
                    }, 5000);
                }
            });
        <?php } ?>
    }

    function insertarCartas(misPeliculas) {
        for (let indice = 0; indice < misPeliculas.length; indice++) {
            $("#contenedorCartas").append(`<div class="col">
                        <div class="card carta-peli h-100" id="${misPeliculas[indice].nom_pelicula}">
                            <img class="img-fluid" src="${misPeliculas[indice].imagen}" class="card-img-top" alt="${misPeliculas[indice].nom_pelicula}">
                            <div class="card-body">
                                <h5 class="card-title">${misPeliculas[indice].nom_pelicula}</h5>
                                <p class="card-text">Géneros: ${misPeliculas[indice].genero_principal}, ${misPeliculas[indice].genero_secundario}. Año: ${misPeliculas[indice].anio}</p>
                                <p class="card-text">${misPeliculas[indice].sinopsis.substring(0, 180).concat('...')}</p>
                                <p class="card-text">Precio: ${misPeliculas[indice].precio}€. Stock: ${misPeliculas[indice].cantidad_disponible}</p>
                            </div>
                            <div class="card-footer row">
                                <a href="#" class="col-5 btn btn-primary" data-id="${misPeliculas[indice].id}" data-comprar="yes">Comprar película</a>
                                <div class="col-2"></div>
                                <a href="#" class="col-5 btn btn-primary" data-id="${misPeliculas[indice].id}"data-alquilar="yes">Alquilar película (80% descuento)</a>
                                </div>
                        </div>
                    </div>`);
        }
    }

    function insertarCartaIndividual(misPeliculas, miBusqueda) {
        misPeliculas.forEach((elemento, indice) => {

            if ( /* $("#contenedorCartas").find(`#${elemento.nom_pelicula}`) &&  */ elemento.nom_pelicula.search(miBusqueda) != -1 || elemento.precio.search(miBusqueda) != -1) {
                $("#contenedorCartas").append(`<div class="col">
                        <div class="card h-100" id="${misPeliculas[indice].nom_pelicula}">
                            <img class="img-fluid" src="${misPeliculas[indice].imagen}" class="card-img-top" alt="${misPeliculas[indice].nom_pelicula}">
                            <div class="card-body">
                                <h5 class="card-title">${misPeliculas[indice].nom_pelicula}</h5>
                                <p class="card-text">Géneros: ${misPeliculas[indice].genero_principal}, ${misPeliculas[indice].genero_secundario}. Año: ${misPeliculas[indice].anio}</p>
                                <p class="card-text">${misPeliculas[indice].sinopsis.substring(0, 180).concat('...')}</p>
                                <p class="card-text">Precio: ${misPeliculas[indice].precio}€. Stock: ${misPeliculas[indice].cantidad_disponible}</p>
                            </div>
                            <div class="card-footer row">
                                <a href="#" class="col-5 btn btn-primary" data-id="${misPeliculas[indice].id}" data-comprar="yes">Comprar película</a>
                                <div class="col-2"></div>
                                <a href="#" class="col-5 btn btn-primary" data-id="${misPeliculas[indice].id}"data-alquilar="yes">Alquilar película</a>
                                </div>
                        </div>
                    </div>`);
            }
        });
    }
</script>

</html>