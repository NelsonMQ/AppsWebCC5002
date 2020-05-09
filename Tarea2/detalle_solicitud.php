<?php
require_once("consultas.php");
require_once('db_config.php');

#Conexion a la base de datos
$db = DbConfig::getConnection();

$id_solicitud;

if($_GET){
    $id_solicitud = $_GET["id"];
}

$solicitud_data_by_id = getSolicitudDataById($db, $id_solicitud)->fetch_assoc();

$comunaRegion = getComunaRegionById($db, $solicitud_data_by_id["comuna_id"]);

$files = getFilesById($db, $solicitud_data_by_id["id"]);

$especialidad = getEspecialidadSolicitante($db, $solicitud_data_by_id["especialidad_id"]);

$db->close();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Inicio</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
    <script src="./js/jquery-3.4.1.min.js"></script>
    <script src="./js/javascript.js"></script>
    <!-- Popper JS -->
    <script src="./js/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="./js/bootstrap.min.js"></script>
</head>
<body>

    <!-- Navbar -->

    <nav class="navbar navbar-expand-lg navbar-dark p m-0" style="background-color: #00539C;">
        <a class="navbar-brand text-white" href="#"><i class="fa fa-rocket" aria-hidden="true"></i></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item mx-2">
                    <a class="nav-link text-white" href="index.php">Inicio</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link text-white" href="agregar_datos_medicos.html">Agregar datos de médico</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link text-white" href="ver_medicos.php">Ver médicos</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link text-white" href="publicar_solicitud_atencion.html">Publicar solicitud de atención</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link text-white" href="ver_solicitudes_atencion.php">Ver solicitudes de atención</a>
                </li>
            </ul>
        </div>
    </nav>



    <div class="m-3">
        <div class="row mx-auto p-2 justify-content-center">
            <h1>Detalle de la Solicitud</h1>
        </div>
        <div class="row mx-auto justify-content-center pb-4 pt-2">
            <table class="table table-striped" style="width: 80%">
                <thead>
                <tr class="text-center font-weight-bold">
                    <td>Nombre</td>
                    <td>Email de contacto</td>
                </tr>
                <tr class="text-center">
                    <?php
                        echo '<td>'.$solicitud_data_by_id["nombre_solicitante"].'</td>';
                        echo '<td>'.$solicitud_data_by_id["email"].'</td>';
                    ?>
                </tr>
                </thead>
                <tbody>
                <tr class="text-center font-weight-bold">
                    <td>Twitter de contacto</td>
                    <td>Número de contacto</td>
                </tr>
                <tr class="text-center">
                    <?php
                        if($solicitud_data_by_id["twitter"]==""){
                            echo '<td>Sin información</td>';
                        }
                        else{
                            echo '<td>'.$solicitud_data_by_id["twitter"].'</td>';
                        }
                        if($solicitud_data_by_id["celular"]==""){
                            echo '<td>Sin información</td>';
                        }
                        else{
                            echo '<td>'.$solicitud_data_by_id["celular"].'</td>';
                        }
                    ?>
                </tr>
                <tr class="text-center font-weight-bold">
                    <td>Región</td>
                    <td>Comuna</td>
                </tr>
                <tr class="text-center">
                    <?php
                        $row = $comunaRegion->fetch_assoc();
                        echo '<td class="align-middle">'.$row["region_nombre"].'</td>';
                        echo '<td class="align-middle">'.$row["nombre_comuna"].'</td>';
                    ?>
                </tr>
                <tr class="text-center font-weight-bold">
                    <td>Especialidad</td>
                    <td>Síntomas</td>
                </tr>
                <tr class="text-center">
                    <?php
                        echo '<td>'.$especialidad->fetch_assoc()["descripcion"].'</td>';
                        echo '<td style="width: 50%" class="align-middle">'.$solicitud_data_by_id["sintomas"].'</td>';    
                    ?>
                </tr>
                <tr class="text-center font-weight-bold">
                    <td>Archivos</td>
                    <td>Tipo</td>
                </tr>
                    <?php
                        while($row = $files->fetch_assoc()) {
                            echo '<tr class="text-center">';
                            echo '<td><a href="'.$row["ruta_archivo"].'">'.$row["nombre_archivo"].'</a></td>';
                            echo '<td>'.$row["mimetype"].'</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="col text-center p-4">
            <a href="ver_solicitudes_atencion.php" class="btn btn-primary">Volver a la lista de Solicitudes</a>
        </div>
    </div>


</body>
</html>