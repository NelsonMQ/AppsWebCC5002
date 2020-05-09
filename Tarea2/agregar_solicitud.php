<?php
require_once("validaciones.php");
require_once("consultas.php");
require_once('db_config.php');

$errores = array();

if($_POST){
    $errores = checkSolicitanteData($_POST);

    if($_FILES){
        if(!checkFiles($_FILES, "archivos-solicitante")){
            $errores[] = "Fotos: Error, maximo 5 archivos.";
        }
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
$db = DbConfig::getConnection();

$get_region_id = getRegionId($db, $_POST["region-solicitante"]);

$get_comuna_id = getComunaId($db, $get_region_id, $_POST["comuna-solicitante"]);

$insert_solicitud = insertSolicitud($db, $_POST["nombre-solicitante"], $_POST["especialidad-solicitud"], $_POST["sintomas-solicitante"], $_POST["twitter-solicitante"], $_POST["email-solicitante"], $_POST["celular-solicitante"], $get_comuna_id);

if($insert_solicitud!=1){
    $errores[] = "Error al insertar los datos.";
    header("Location: index.php?success=0&errores=".implode($errores, "<br>"));
    return;
}

$id_solicitud = $db->insert_id;
if($_FILES){
    $insert_files = insertFilesSolicitante($db, $id_solicitud, $_FILES["archivos-solicitante"]);

    if($insert_files!=1){
        $errores[] = "Error al insertar los datos.";
        header("Location: index.php?success=0&errores=".implode($errores, "<br>"));
        return;
    }
}

$db->close();

header("Location: index.php?success=1&errores=Solicitud agregada exitosamente!.");
return;



?>