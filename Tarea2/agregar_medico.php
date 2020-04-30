<?php
require_once("validaciones.php");
require_once("consultas.php");

$errores = array();

if($_POST){
    $errores = checkMedicoData($_POST);

    if($_FILES){
        if(!checkImagesFiles($_FILES, "foto-medico")){
            $errores[] = "Fotos: Error, archivos deben ser imagenes, maximo 5 minimo 1.";
        }
    }
    else{
        $errores[] = "Debe ingresar al menos una foto.";
    }
}
else{
    $errores[] = "Debe ingresar datos.";
}

if(count($errores)>0){
    header("Location: index.php?success=0&errores=".implode($errores, "<br>"));
    return;
}


#Conexion a la base de datos
$db = new mysqli("localhost", "cc5002", "programacionweb", "tarea2")
        or die('No se ha podido conectar: ' . $mysqli->connect_error);

$db->set_charset("utf8");

$get_region_id = getRegionId($db, $_POST["region-medico"]);

$get_comuna_id = getComunaId($db, $get_region_id, $_POST["comuna-medico"]);

$insert_medico = insertMedico($db, $_POST["nombre-medico"], $_POST["experiencia-medico"], $get_comuna_id, $_POST["twitter-medico"], $_POST["email-medico"], $_POST["celular-medico"]);

if($insert_medico!=1){
    $errores[] = "Error al insertar los datos.";
    header("Location: index.php?success=0&errores=".implode($errores, "<br>"));
    return;
}

$id_medico = $db->insert_id;

$insert_especialidades = insertEspecialidadesMedico($db, $id_medico, $_POST["especialidades-medico"]);

if($insert_especialidades!=1){
    $errores[] = "Error al insertar los datos.";
    header("Location: index.php?success=0&errores=".implode($errores, "<br>"));
    return;
}

$insert_images = insertImagesMedico($db, $id_medico, $_FILES["foto-medico"]);

if($insert_images!=1){
    $errores[] = "Error al insertar los datos.";
    header("Location: index.php?success=0&errores=".implode($errores, "<br>"));
    return;
}

$db->close();

header("Location: index.php?success=1&errores=Médico agregado exitosamente!.");
return;

?>