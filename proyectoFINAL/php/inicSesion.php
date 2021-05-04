<?php
include "connectDB.php";
function iniciarSesion($conexion)
{
    //Obtenemos los datos del formulario
    $user = $_POST['user'];
    $password = $_POST['password'];
    //Buscamos en la base de datos. Si el usuario existe, inicia sesión. Si no, avisará al usuario.
    $sentencia = $conexion->prepare("SELECT nom_usuario, email FROM usuarios WHERE usuarios.nom_usuario = ? and usuarios.password = ?");
    $sentencia->bind_param('ss', $user, $password);
    $sentencia->execute();
    $resultado = $sentencia->get_result();
    $resultSentencia = $resultado->fetch_all(MYSQLI_ASSOC);

    if (count($resultSentencia) == 0) {
        return false;
    } else {
        //Si el usuario y la contraseña coinciden, se crea una sesión.
        echo "Existe";
        $valores = [
            "userId" => $resultSentencia[0]["nom_usuario"],
            "email" =>  $resultSentencia[0]["email"]
        ];
        $_SESSION['datosUsuario'] = $valores;
        //Creamos una variable con el nombre de usuario.
        echo "<script>
                    let nombre = " . $resultSentencia[0]["nom_usuario"] . "
              </script>";
    }
}



$conect = new Conexion("localhost", "root", "", "bd_videoclub");
iniciarSesion($conect->dbh);
