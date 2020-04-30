<?php

require_once("consultas.php");

#Conexion a la base de datos
$db = new mysqli("localhost", "cc5002", "programacionweb", "tarea2")
        or die('No se ha podido conectar: ' . $mysqli->connect_error);

$db->set_charset("utf8");

$medicos_data = numberOfPages($db);

echo (int)($medicos_data/5);

?>