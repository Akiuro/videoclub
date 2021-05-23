<?php
include "connectDB.php";
session_start();
function iniciarSesion($conexion)
{


    //Obtenemos los datos del formulario
    $user = $_POST['user'];
    //Buscamos en la base de datos. Si el usuario existe, inicia sesión. Si no, avisará al usuario.
    $sentencia = $conexion->prepare("SELECT * FROM usuarios WHERE usuarios.nom_usuario = ? or usuarios.email = ?");
    $sentencia->bind_param('ss', $user, $user);
    $sentencia->execute();

    //Si se ha leido algo, comprobamos las contraseñas.
    $resultado = $sentencia->get_result();
    $resultSentencia = $resultado->fetch_all(MYSQLI_ASSOC);

    if (password_verify($_POST['password'], $resultSentencia[0]['password'])) {
        echo "Existe";
        //Se hace consulta para obtener los datos del usuario, y crear una sesión con ellos.
        /* echo $resultSentencia[0]["nom_usuario"], $resultSentencia[0]["email"], $resultSentencia[0]["estado"], $resultSentencia[0]["password"], $resultSentencia[0]["id"]; */
        $valores = [
            "userId" => $resultSentencia[0]["nom_usuario"],
            "email" =>  $resultSentencia[0]["email"],
            "tipo" => $resultSentencia[0]["tipo_usuario"]
        ];
        $_SESSION['datosUsuario'] = $valores;
    } else {
        echo "No existe";
    }
}
function crearUsuario($conexion)
{
    //Obtenemos los datos de la creación del usuario.
    $nuevoUsuario = $_POST['nombre'];
    $nuevoEmail = $_POST['email'];
    $password = $_POST['password'];
    //Encriptamos la contraseña.
    $nuevaPassword = password_hash($password, PASSWORD_DEFAULT);

    //Añadimos los datos a las tablas usuario de la base de datos.

    $sentencia = $conexion->prepare("INSERT INTO `usuarios` (`nom_usuario`, `email`, `estado`, `password`,`tipo_usuario`, `id`) VALUES (?,?,1,?,'normal', NULL);");
    $sentencia->bind_param('sss', $nuevoUsuario, $nuevoEmail, $nuevaPassword);
    $sentencia->execute();
    $sentencia->close();
}

function comprobarRepetido($conexion)
{
    $user = $_POST['user'];
    $email = $_POST['email'];
    //Buscamos en la base de datos. Si el usuario existe, inicia sesión. Si no, avisará al usuario.
    $sentencia = $conexion->prepare("SELECT nom_usuario FROM usuarios WHERE usuarios.nom_usuario = ? or usuarios.email = ?");
    $sentencia->bind_param('ss', $user, $email);
    $sentencia->execute();
    $resultado = $sentencia->get_result();
    $resultSentencia = $resultado->fetch_all(MYSQLI_ASSOC);
    if (count($resultSentencia) > 0) {
        echo "Existe el user";
    } else {
        echo "No existe el user";
    }
}

function insertarPelicula($conexion)
{
    //Almacenamos todo lo recibido en variables.

    $nom_peli = $_REQUEST['nom_peli'];
    $nom_original = $_REQUEST['nom_original'];
    $genero_princ = $_REQUEST['genero_princ'];
    $genero_secund = $_REQUEST['genero_secund'];
    $imagen = $_REQUEST['imagen'];
    $sinopsis = $_REQUEST['sinopsis'];
    $anio = $_REQUEST['anio'];
    $pais = $_REQUEST['pais'];
    $soporte = $_REQUEST['soporte'];
    $cantidad = $_REQUEST['cantidad'];
    $precio = $_REQUEST['precio'];

    //Creamos la sentencia

    $sentencia = $conexion->prepare("INSERT INTO `peliculas` (`nom_pelicula`, `nom_original`, `genero_principal`, `genero_secundario`, `imagen`, `sinopsis`, `anio`, `pais`, `soporte`, `cantidad_disponible`, `precio`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $sentencia->bind_param('sssssssssis', $nom_peli, $nom_original, $genero_princ, $genero_secund, $imagen, $sinopsis, $anio, $pais, $soporte, $cantidad, $precio);
    $sentencia->execute();
    /* printf(" Error:% s. \ N ", $sentencia->error); */
    $sentencia->close();
}

function obtenerGeneros($conexion){

//Obtenemos todos los géneros disponibles en la base de datos.
$sentencia = $conexion->query("SELECT * FROM `generos`");
$obtenido = $sentencia->fetch_all(MYSQLI_ASSOC);
    echo json_encode($obtenido, JSON_UNESCAPED_UNICODE);


}

function obtenerPeliculas($conexion){
    $sentencia = $conexion->query("SELECT * FROM `peliculas`");
    $obtenido = $sentencia->fetch_all(MYSQLI_ASSOC);
        echo json_encode($obtenido, JSON_UNESCAPED_UNICODE);
    

}
function unaPelicula($conexion){
    $id_peli = $_REQUEST['id'];
    $sentencia = $conexion->query("SELECT * FROM `peliculas` WHERE id LIKE '$id_peli';");
    $obtenido = $sentencia->fetch_all(MYSQLI_ASSOC);
        echo json_encode($obtenido, JSON_UNESCAPED_UNICODE);
}

//Realizamos la conexión a la BDD, para poder pasarla por parámetro a las funciones.
$conect = new Conexion("localhost", "root", "", "bd_videoclub");
//Recogemos el valor pasado por parámetro. Según su valor, el switch usará una función u otra.
$valor = $_REQUEST['valor'];

switch ($valor) {
    case 'iniciarSesion':
        iniciarSesion($conect->dbh);
        break;
    case 'registroUsuario':
        crearUsuario($conect->dbh);
        break;
    case 'comprobarRepetido':
        comprobarRepetido($conect->dbh);
        break;
    case 'insertarPelicula':
        insertarPelicula($conect->dbh);
        break;
        case 'obtenerGeneros':
            obtenerGeneros($conect->dbh);
        break;
        case 'obtenerPeliculas':
            obtenerPeliculas($conect->dbh);
        break;
        case 'unaPelicula':
            unaPelicula($conect->dbh);
            break;
    default:

        break;
}
