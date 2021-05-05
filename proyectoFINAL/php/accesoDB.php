<?php


include "connectDB.php";

function insertarUsuario($conexion)
{

    $sql = $conexion->prepare("INSERT INTO `usuarios` (`nombre`, `email`, `estado`, `password`) VALUES (?,?,?,?)");

    $nombre = $_REQUEST['nombre'];
    $email = $_REQUEST['email'];
    $estado = $_REQUEST['estado'];

    //Para seguridad, encriptaremos la contraseña.

    $password = password_hash($_REQUEST['password'], PASSWORD_DEFAULT);

    $sql->bind_param('ssis', $nombre, $email, $estado, $password);

    try {
        $sql->execute();
    } catch (Throwable $th) {
    }


    $sql->close();
}
/* 
function obtenerCliente($conexion)
{
    $resultado = $conexion->query("SELECT * FROM `clientes`");
    $obtenido = $resultado->fetch_all(MYSQLI_ASSOC);
    echo json_encode($obtenido);
} */



$conect = new Conexion("localhost", "root", "", "bd_videoclub");

switch ($_POST['valor']) {
    case 'insertarUsuario':
        insertarUsuario($conect->dbh);
        break;
    case '#':

        break;
    case '#':

        break;
}
