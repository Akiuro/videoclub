<?php
include "connectDB.php";
session_start();
function iniciarSesion($conexion)
{


    //Obtenemos los datos del formulario
    $user = $_POST['nombre'];
    //Buscamos en la base de datos. Si el usuario existe, inicia sesión. Si no, avisará al usuario.
    $sentencia = $conexion->prepare("SELECT * FROM usuarios WHERE usuarios.nom_usuario = ? or usuarios.email = ?");
    $sentencia->bind_param('ss', $user, $user);
    $sentencia->execute();

    //Si se ha leido algo, comprobamos las contraseñas.
    $resultado = $sentencia->get_result();
    $resultSentencia = $resultado->fetch_all(MYSQLI_ASSOC);
    if (isset($resultSentencia[0]['nom_usuario'])) {

        if (password_verify($_POST['password'], $resultSentencia[0]['password'])) {
            //Comprobamos si el usuario está baneado.
            if ($resultSentencia[0]["estado"] == 0) {
                echo "Baneado";
            } else {
                echo "Existe";
                //Se hace consulta para obtener los datos del usuario, y crear una sesión con ellos.
                $valores = [
                    "userId" => $resultSentencia[0]["nom_usuario"],
                    "numericId" => $resultSentencia[0]["id"],
                    "email" =>  $resultSentencia[0]["email"],
                    "tipo" => $resultSentencia[0]["tipo_usuario"],
                    "cartera" => $resultSentencia[0]["cartera"]
                ];
                $_SESSION['datosUsuario'] = $valores;
            }
        } else {
            echo "No existe";
        }
    } else {
        echo "No hay usuario";
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

    $sentencia = $conexion->prepare("INSERT INTO `usuarios` (`nom_usuario`, `email`, `estado`, `password`,`tipo_usuario`, `cartera`,  `id`) VALUES (?,?,1,?,'normal',00.00,  NULL);");
    $sentencia->bind_param('sss', $nuevoUsuario, $nuevoEmail, $nuevaPassword);
    $sentencia->execute();
    $sentencia->close();
}

function eliminarUsuario($conexion)
{
    $usuarioEliminado = $_POST['usuario'];
    $sentencia = $conexion->prepare("DELETE FROM `usuarios` WHERE `usuarios`.`id` = ?;");
    $sentencia->bind_param('s', $usuarioEliminado);
    $sentencia->execute();
    $sentencia->close();
}

function obtenerUsuarios($conexion)
{
    //Obtenemos todos los géneros disponibles en la base de datos.
    $sentencia = $conexion->query("SELECT * FROM `usuarios`");
    $obtenido = $sentencia->fetch_all(MYSQLI_ASSOC);
    echo json_encode($obtenido, JSON_UNESCAPED_UNICODE);
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

function ban_unbanUsuario($conexion)
{
    $id_usuario = $_POST["id_usuario"];
    $sentencia = $conexion->query("SELECT `estado` FROM `usuarios` WHERE `usuarios`.`id` = $id_usuario;");
    $obtenido = $sentencia->fetch_all(MYSQLI_ASSOC);
    $baneado = $obtenido[0]["estado"];

    if ($baneado == 1) {
        //Si el usuario no está baneado, se le banea. Si no, viceversa.
        $conexion->query("UPDATE `usuarios` SET `estado` = 0 WHERE `usuarios`.`id` = $id_usuario;");
    } else {
        $conexion->query("UPDATE `usuarios` SET `estado` = 1 WHERE `usuarios`.`id` = $id_usuario;");
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

function obtenerGeneros($conexion)
{
    //Obtenemos todos los géneros disponibles en la base de datos.
    $sentencia = $conexion->query("SELECT * FROM `generos`");
    $obtenido = $sentencia->fetch_all(MYSQLI_ASSOC);
    echo json_encode($obtenido, JSON_UNESCAPED_UNICODE);
}

function obtenerPeliculas($conexion)
{
    $sentencia = $conexion->query("SELECT * FROM `peliculas` ORDER BY `anio` DESC");
    $obtenido = $sentencia->fetch_all(MYSQLI_ASSOC);
    echo json_encode($obtenido, JSON_UNESCAPED_UNICODE);
}
function peliculaVista($conexion){
    if(isset($_SESSION["datosUsuario"]["userId"])){
        $usuario = $_SESSION["datosUsuario"]["userId"];
    }
    else{
        $usuario = "none";
    }
    $pelicula=$_POST['pelicula'];
        $sentencia = $conexion->query("SELECT * FROM `ventas_alquileres` WHERE `cliente` LIKE '$usuario' and `nombre_pelicula` like '$pelicula'");
        $obtenido = $sentencia->fetch_all(MYSQLI_ASSOC);
        echo json_encode($obtenido, JSON_UNESCAPED_UNICODE);
    
}
function unaPelicula($conexion)
{
    $id_peli = $_REQUEST['id'];
    $sentencia = $conexion->query("SELECT * FROM `peliculas` WHERE `id` LIKE '$id_peli';");
    $obtenido = $sentencia->fetch_all(MYSQLI_ASSOC);
    echo json_encode($obtenido, JSON_UNESCAPED_UNICODE);
}
function mostrarVentas($conexion)
{
    $usuario = $_REQUEST['usuario'];
    $sentencia = $conexion->query("SELECT * FROM `ventas_alquileres` WHERE cliente LIKE '$usuario' ORDER BY `ventas_alquileres`.`fecha_inicio` DESC;");
    $obtenido = $sentencia->fetch_all(MYSQLI_ASSOC);
    echo json_encode($obtenido, JSON_UNESCAPED_UNICODE);
}
function mostrarTodasVentas($conexion)
{
    $sentencia = $conexion->query("SELECT * FROM `ventas_alquileres` ORDER BY `ventas_alquileres`.`cliente` DESC;");
    $obtenido = $sentencia->fetch_all(MYSQLI_ASSOC);
    echo json_encode($obtenido, JSON_UNESCAPED_UNICODE);
}

function devolverPelicula($conexion)
{
    $usuario = $_SESSION["datosUsuario"]["userId"];
    $id = $_REQUEST['id_prestamo'];
    $conexion->query("UPDATE `ventas_alquileres` SET `devuelto` = 'Si' WHERE `ventas_alquileres`.`id_prestamo` = $id;");
    //Obtenemos el nombre de la pelicula
    $sentencia = $conexion->query("SELECT pr.`tipo`, pe.`cantidad_disponible`, pe.`nom_pelicula`, pe.`precio` FROM `peliculas` AS pe INNER JOIN ventas_alquileres AS pr ON pe.nom_pelicula = pr.nombre_pelicula WHERE `pr`.`id_prestamo` = $id;");
    $obtenido = $sentencia->fetch_all(MYSQLI_ASSOC);
    $cantidadPelicula = $obtenido[0]["cantidad_disponible"];
    $tipo = $obtenido[0]["tipo"];
    $nombrePelicula = $obtenido[0]["nom_pelicula"];
    $precioPelicula = $obtenido[0]["precio"]*0.2;
    $nuevaCantidad = $cantidadPelicula + 1;
    $conexion->query("UPDATE `peliculas` SET `cantidad_disponible` = '$nuevaCantidad' WHERE `nom_pelicula` = '$nombrePelicula';");
    //Añadimos el saldo al saldo anterior.
    $conexion->query("UPDATE `usuarios` SET `cartera` = `cartera`+'$precioPelicula' WHERE `usuarios`.`nom_usuario` ='$usuario';");
    $sentencia2 = $conexion->query("SELECT `cartera` FROM `usuarios` WHERE `usuarios`.`nom_usuario` ='$usuario';");
    $obtenido2 = $sentencia2->fetch_all(MYSQLI_ASSOC);
    $new_cartera = $obtenido2[0]["cartera"];
    $_SESSION["datosUsuario"]["cartera"] = $new_cartera;
}

function insertarVenta($conexion)
{
    $usuario = $_SESSION["datosUsuario"]["userId"];
    $nombre = $_POST['nom_pelicula'];
    $tipo = $_POST['tipo'];
    

    if($tipo =="compra"){
        $precio = $_POST['precio'];
        $devuelto = "Si";  
    }
    else{
        $precio = $_POST['precio']*0.2;
        $devuelto = "No";  
    }
    
    $fecha_actual = date("Y-m-d");
    $fecha_final = strtotime("+7 day");
    $fecha_fin = date("Y-m-d", $fecha_final);
    //Obtenemos el dinero de la cartera del usuario.
    $sentencia = $conexion->query("SELECT `cartera` FROM `usuarios` WHERE `usuarios`.`nom_usuario` LIKE '$usuario';");
    $obtenido = $sentencia->fetch_all(MYSQLI_ASSOC);
    $old_cartera = $obtenido[0]["cartera"];
    $new_cartera = $old_cartera - $precio;
    //Comprobamos si tiene saldo suficiente. Si lo tiene, ejecutará la venta y restará el sueldo, si no, arrojará un aviso al usuario.
    if ($new_cartera >= 0) {
        //Restamos al usuario el dinero de su cartera.
        $conexion->query("UPDATE `usuarios` SET `cartera` = '$new_cartera' WHERE `usuarios`.`nom_usuario` ='$usuario';");
        $_SESSION["datosUsuario"]["cartera"] = $new_cartera;
        $conexion->query("INSERT INTO `ventas_alquileres` (`nombre_pelicula`, `cliente`, `tipo`, `fecha_inicio`, `fecha_fin`, `precio`, `devuelto`, `id_prestamo`) VALUES ('$nombre', '$usuario', '$tipo', '$fecha_actual', '$fecha_fin', '$precio', '$devuelto', NULL);");
        //A continuación, reducimos en 1 el stock de la tienda.
        $conexion->query("UPDATE `peliculas` SET `cantidad_disponible` = `cantidad_disponible`-1 WHERE `peliculas`.`nom_pelicula` ='$nombre';");
    } else {
        echo "No hay dinero";
    }
}

function ingresarDinero($conexion)
{
    $ingreso = $_POST['ingreso'];
    $usuario = $_SESSION["datosUsuario"]["userId"];

    $sentencia = $conexion->query("SELECT `cartera` FROM `usuarios` WHERE `usuarios`.`nom_usuario` LIKE '$usuario';");
    $obtenido = $sentencia->fetch_all(MYSQLI_ASSOC);
    $old_cartera = $obtenido[0]["cartera"];
    $new_cartera = $old_cartera + $ingreso;

    $conexion->query("UPDATE `usuarios` SET `cartera` = '$new_cartera' WHERE `usuarios`.`nom_usuario` = '$usuario';");
    $_SESSION["datosUsuario"]["cartera"] = $new_cartera;
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
        iniciarSesion($conect->dbh);
        break;
    case 'eliminarUsuario':
        eliminarUsuario($conect->dbh);
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
    case 'mostrarVentas':
        mostrarVentas($conect->dbh);
        break;
    case 'todasVentas':
        mostrarTodasVentas($conect->dbh);
        break;
    case 'devolver':
        devolverPelicula($conect->dbh);
        break;
    case 'vender':
        insertarVenta($conect->dbh);
        break;
    case 'ingresarDinero':
        ingresarDinero($conect->dbh);
        break;
    case 'mostrarUsuarios':
        obtenerUsuarios($conect->dbh);
        break;
    case 'banear':
        ban_unbanUsuario($conect->dbh);
        break;
        case 'peliculaVista':
            peliculaVista($conect->dbh);
            break;
    default:

        break;
}
