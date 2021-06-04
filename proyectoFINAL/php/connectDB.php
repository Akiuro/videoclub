<?php
header('Content-Type: text/html; charset=UTF-8');
class Conexion
{

    public $dbh;

    function __construct($host, $user, $pw, $db)
    {

        $conexion =  mysqli_connect($host, $user, $pw, $db);


        if (mysqli_error($conexion)) {
            throw new Exception("Error conectando la base de datos", 1);
        }
        $this->dbh = $conexion;
    }
}
