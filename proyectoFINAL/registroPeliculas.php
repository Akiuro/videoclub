<?php session_start();
?>
<!DOCTYPE html>
<html lang="es">

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

</head>

<body>
  <div id="header"><?php require_once "maquetacion/header.php" ?> </div>
  <form action="#" method="post" id="registrarPelicula">
    <div class="container contact">
      <div class="row">
        <div class="col-md-3">
          <div class="contact-info">

            <h2>Bienvenido administrador.</h2>
            <h4>Inserta todos los datos de la pelicula.</h4>
          </div>
        </div>
        <div class="col-md-9">
          <div class="contact-form">
            <div class="form-group">
              <label class="control-label col-sm-3" for="nom_peli">Nombre de la pelicula</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="nom_peli" placeholder="Ej: Mulán" name="nom_peli" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3" for="nom_original">Nombre original</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="nom_original" placeholder="Ej: Hua Mulan" name="nom_original" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3" for="genero_princ">Genero principal</label>
              <div class="col-sm-10">
                <select class="form-control" name="genero_princ" id="genero_princ" required></select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3" for="genero_secund">Genero secundario</label>
              <div class="col-sm-10">
                <select class="form-control" name="genero_secund" id="genero_secund" required></select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3" for="anio">Año</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="anio" placeholder="Ej: 2020" name="anio" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3" for="pais">País</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="pais" placeholder="Ej: Estados Unidos" name="pais" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3" for="soporte">Soporte</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="soporte" placeholder="Ej: Fisico/Digital" name="soporte" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3" for="cantidad">Cantidad</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="cantidad" placeholder="Ej: 5" name="cantidad" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3" for="precio">Precio (En €)</label>
              <div class="col-sm-10">
                <input type="number" class="form-control" id="precio" placeholder="Ej: 15.2" name="precio" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3" for="sinopsis">Sinopsis:</label>
              <div class="col-sm-10">
                <textarea class="form-control" rows="5" id="sinopsis" required></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3" for="imagen">Imagen:</label>
              <div class="col-sm-10">
                <input type="file" class="" id="imagen" name="imagen" required>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button id="registrarPelicula" type="submit" class="btn btn-default">Submit</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
  <div id="footer"><?php require_once "maquetacion/footer.php" ?></div>
</body>
<script>
  //Creamos elementos de forma dinámica al iniciar la página.

  $(document).ready(function(e) {
    //Hacemos llamada a ajax y obtenemos todos los géneros existentes en la base de datos.
    ajax("php/manejadorDB.php", "POST", {
      valor: "obtenerGeneros"
    }, function(e) {

      let arrayGeneros = JSON.parse(e);

      //Creamos una cadena HTML para poder insertarla en el formulario.
      let cadenaHTML = "";
      for (let indice = 0; indice < arrayGeneros.length; indice++) {
        $("#genero_princ").append(`<option value="${arrayGeneros[indice].tipoGenero}">${arrayGeneros[indice].tipoGenero}</option>`);
        $("#genero_secund").append(`<option value="${arrayGeneros[indice].tipoGenero}">${arrayGeneros[indice].tipoGenero}</option>`);

      }
    });
  });

  $("#registrarPelicula").on("submit", function(e) {
    e.preventDefault();


    //Creamos objeto datos con todo lo que se va a recibir.

    let datos = new Object;
    datos.nom_peli = $("#nom_peli").val();
    datos.nom_original = $("#nom_original").val();
    datos.genero_princ = $("#genero_princ").val();
    datos.genero_secund = $("#genero_secund").val();
    let imagen = $("#imagen").val();
    datos.imagen = "assets/images/films/" + imagen.substr(12, imagen.length);
    datos.sinopsis = $("#sinopsis").val();
    datos.anio = $("#anio").val();
    datos.pais = $("#pais").val();
    datos.soporte = $("#soporte").val();
    datos.cantidad = $("#cantidad").val();
    datos.precio = $("#precio").val();
    datos.valor = "insertarPelicula";
    //Llamamos a ajax e insertamos todos los datos en la base de datos.
    ajax("php/manejadorDB.php", "POST", datos, function(e) {});

    //Limpiamos el formulario y avisamos al usuario de que la inserción ha sido realizada.

    $("#registrarPelicula")[0].reset();
    alert("Pelicula registrada.");
  });
</script>

</html>