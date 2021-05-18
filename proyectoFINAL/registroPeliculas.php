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
</head>

<body>
    <form action="#" method="post" id="registrarPelicula">
        <label for="nom_peli">Nombre de la pelicula</label>
        <input type="text" name="nom_peli" id="nom_peli">
        <label for="nom_original">Nombre original</label>
        <input type="text" name="nom_original" id="nom_original">
        <label for="genero_princ">Género principal</label>
        <select name="genero_princ" id="genero_princ"></select>
        <label for="genero_secund">Género secundario</label>
        <select name="genero_secund" id="genero_secund"></select>
        <label for="imagen">Imagen</label>
        <input type="text" name="imagen" id="imagen">
        <label for="sinopsis">Sinopsis</label>
        <textarea name="sinopsis" id="sinopsis" cols="30" rows="10"></textarea>
        <label for="anio">Año</label>
        <input type="text" name="anio" id="anio">
        <label for="pais">País</label>
        <input type="text" name="pais" id="pais">
        <label for="soporte">Soporte</label>
        <input type="text" name="soporte" id="soporte">
        <label for="cantidad">Cantidad</label>
        <input type="text" name="cantidad" id="cantidad">

        <input type="submit" value="Enviar">
    </form>
    <button action="index.php"><a href="index.php">Volver al index</a></button>
</body>
<script>

    //Creamos elementos de forma dinámica al iniciar la página.

    $(document).ready(function(e){
        //Hacemos llamada a ajax y obtenemos todos los géneros existentes en la base de datos.
        ajax("php/manejadorDB.php", "POST", {valor:"obtenerGeneros"}, function(e){
  
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
        let imagen = `assets/images/films/`;
        imagen+= $("#imagen").val();
        datos.imagen = imagen;
        datos.sinopsis = $("#sinopsis").val();
        datos.anio = $("#anio").val();
        datos.pais = $("#pais").val();
        datos.soporte = $("#soporte").val();
        datos.cantidad = $("#cantidad").val();
        datos.valor = "insertarPelicula";
        //Llamamos a ajax e insertamos todos los datos en la base de datos.

        ajax("php/manejadorDB.php", "POST", datos, function(e) {

        });

        //Limpiamos el formulario y avisamos al usuario de que la inserción ha sido realizada.

        $("#registrarPelicula")[0].reset();
        alert("Pelicula registrada.");
    });
</script>

</html>