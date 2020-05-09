<?php
require_once("consultas.php");
require_once('db_config.php');

#Conexion a la base de datos
$db = DbConfig::getConnection();

$id_medico;

if($_GET){
    $id_medico = $_GET["id"];
}

$medico_data_by_id = getMedicoDataById($db, $id_medico)->fetch_assoc();
$comunaRegion = getComunaRegionById($db, $medico_data_by_id["comuna_id"]);
$images = getImagesById($db, $medico_data_by_id["id"]);
$especialidades = getEspecialidadesMedico($db, $medico_data_by_id["id"]);

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

    <div class="p-5">
        <div class="row mx-auto justify-content-center rounded-pill py-4">
            <h1>Detalle del Médico</h1>
        </div>
        <div class="row mx-auto justify-content-center my-4 py-4 rounded">
            <?php
            $i = 1;
            while($row = $images->fetch_assoc()) {
                echo '<img src="'.$row["ruta_archivo"].'" alt="Foto del Médico" width="320" height="240" class="mx-2 rounded border border-dark" id="img-'.$i.'" onclick="mostrarImagen(\'img-div\', \'img-'.$i.'\')">';
                $i= $i+1;
            }
            ?>
        </div>
        <div class="row mx-auto justify-content-center my-4 py-4 rounded">
            <div id="img-div">

            </div>
            <div class="col py-4 pr-5 d-flex justify-content-center">
                <table class="table table-striped border table-bordered" style="width: 80%">
                    <thead>
                    <tr class="text-center font-weight-bold">
                        <td>Nombre</td>
                        <td>Email de contacto</td>
                    </tr>
                    <tr class="text-center">
                        <?php
                            echo '<td>'.$medico_data_by_id["nombre"].'</td>';
                            echo '<td>'.$medico_data_by_id["email"].'</td>';
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
                            if($medico_data_by_id["twitter"]==""){
                                echo '<td>Sin información</td>';
                            }
                            else{
                                echo '<td>'.$medico_data_by_id["twitter"].'</td>';
                            }
                            if($medico_data_by_id["celular"]==""){
                                echo '<td>Sin información</td>';
                            }
                            else{
                                echo '<td>'.$medico_data_by_id["celular"].'</td>';
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
                            echo '<td>'.$row["region_nombre"].'</td>';
                            echo '<td>'.$row["nombre_comuna"].'</td>';
                        ?>
                    </tr>
                    <tr class="text-center font-weight-bold">
                        <td>Especialidades</td>
                        <td>Experiencia</td>
                    </tr>
                    <tr class="text-center">
                        <?php
                        echo '<td>';
                            while($row = $especialidades->fetch_assoc()) {
                                echo  $row["descripcion"].'<br> <br>';
                            }
                            echo '</td>';
                            echo '<td style="width: 50%" class="align-middle">'.$medico_data_by_id["experiencia"].'</td>';
                        ?>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col text-center p-4">
            <a href="ver_medicos.php" class="btn btn-primary">Volver a la lista de Médicos</a>
        </div>
    </div>



</body>
</html>