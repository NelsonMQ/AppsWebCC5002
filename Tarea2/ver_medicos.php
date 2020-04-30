<?php
require_once("consultas.php");

#Conexion a la base de datos
$db = new mysqli("localhost", "cc5002", "programacionweb", "tarea2")
        or die('No se ha podido conectar: ' . $mysqli->connect_error);

$db->set_charset("utf8");

$page = 1;

if($_GET){
    $page = $_GET["page"];
}


$offset = ((int)$page-1)*5;

$numberOfPages = numberOfPages($db, "medico");

$medicos_data = getMedicosData($db, $offset);

?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Médicos</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="./css/mycss.css">
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

        <!-- Table -->

        <div class="row p-4">
            <table class="table mx-auto justify-content-center border" style="width: 80%">
                <thead>
                <tr>
                    <th scope="col">Nombre Médicos</th>
                    <th scope="col">Especialidades</th>
                    <th scope="col">Comuna</th>
                    <th scope="col">Datos de contacto</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                        while($row = $medicos_data->fetch_assoc()) {
                            echo '<tr class="clickable-row" data-href="detalle_medico.php?id='.$row["id"].'">';
                            echo '<th scope="row">'.$row["nombre"].'</th>';
                            echo "<td>";
                            $especialidades_medico = getEspecialidadesMedico($db, $row["id"]);
                            while($especialidad_row = $especialidades_medico->fetch_assoc()){
                                echo $especialidad_row["descripcion"].'<br><br>';
                            }
                            echo "</td>";
                            $comuna = getComunaRegionById($db, $row["comuna_id"])->fetch_assoc()["nombre_comuna"];
                            echo "<td>".$comuna."</td>";
                            echo "<td>".$row["email"].'<br>'.$row["twitter"].'<br>'.$row["celular"]."</td>";
                            echo "</td>";
                        }
                    ?>
                </tbody>
            </table>
        </div>


        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php
                    if($page<2){
                        echo '<li class="page-item disabled"><a class="page-link" href="" tabindex="-1">Anterior</a></li>';
                    }
                    else{
                        echo '<li class="page-item"><a class="page-link" href="ver_medicos.php?page='.($page-1).'" tabindex="-1">Anterior</a></li>';
                    }
                    echo '<li class="page-item active"><span class="page-link">'.$page.'<span class="sr-only">(current)</span></span></li>';
                    if($page>=$numberOfPages){
                        echo '<li class="page-item disabled"><a class="page-link" href="" tabindex="-1">Siguiente</a></li>';
                    }
                    else{
                        echo '<li class="page-item"><a class="page-link" href="ver_medicos.php?page='.($page+1).'">Siguiente</a></li>';
                    }
                        
                ?>


            </ul>
        </nav>

    </body>
</html>