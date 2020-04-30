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
                <?php
                    if($_GET){
                        if($_GET["success"]==1){
                            echo '<li class="nav-item mx-2"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$_GET["errores"].'</div></li>';
                        }
                        else{
                        echo '<li class="nav-item mx-2"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$_GET["errores"].'</div></li>';
                        }
                    }
                ?>
              </ul>
            </div>
        </nav>
    
        <!-- Jumbotrons -->

        <div class="jumbotron jumbotron-fluid m-0" style="background-color: #FF6F61; text-align: left;"
        >
            <div class="container d-flex align-items-center">
                <div class= "container-fluid" style="width: 70%;">
                    <h1 class="display-3">Agregar datos de Médico</h1>
                    <p class="lead">
                        <a class="btn btn-primary btn-lg" href="agregar_datos_medicos.html" role="button">Agregar datos</a>
                    </p>
                </div>
                <div class="d-flex mx-auto align-items-center" style="width: 30%;">
                    <img src="./imgs/medic_data.png" alt="Medico" class="img-fluid">
                </div>
            </div>
        </div>

        <div class="jumbotron jumbotron-fluid m-0" style="background-color: #FA9A85; text-align: left;"
        >
            <div class="container d-flex align-items-center">
                <div class= "container-fluid" style="width: 70%;">
                    <h1 class="display-3">Publicar solicitud de atención</h1>
                    <p class="lead">
                        <a class="btn btn-primary btn-lg" href="publicar_solicitud_atencion.html" role="button">Publicar solicitud</a>
                    </p>
                </div>
                <div class="d-flex mx-auto align-items-center" style="width: 30%;">
                    <img src="./imgs/solicitud.png" alt="Solicitud" class="img-fluid">
                </div>
            </div>
        </div>

        <div class="jumbotron jumbotron-fluid m-0" style="background-color: #FF6F61; text-align: left;"
        >
            <div class="container d-flex align-items-center">
                <div class= "container-fluid" style="width: 70%;">
                    <h1 class="display-3">Ver datos de Médicos</h1>
                    <p class="lead">
                        <a class="btn btn-primary btn-lg" href="ver_medicos.php" role="button">Ver Médicos</a>
                    </p>
                </div>
                <div class="d-flex mx-auto align-items-center" style="width: 30%;">
                    <img src="./imgs/medic.png" alt="Medico" class="img-fluid">
                </div>
            </div>
        </div>

        <div class="jumbotron jumbotron-fluid m-0" style="background-color: #FA9A85; text-align: left;"
        >
            <div class="container d-flex align-items-center">
                <div class= "container-fluid" style="width: 70%;">
                    <h1 class="display-3">Ver solicitudes de atención</h1>
                    <p class="lead">
                        <a class="btn btn-primary btn-lg" href="ver_solicitudes_atencion.php" role="button">Ver solicitudes</a>
                    </p>
                </div>
                <div class="d-flex mx-auto align-items-center" style="width: 30%;">
                    <img src="./imgs/solicitud_data.png"  alt="Solicitudes" class="img-fluid">
                </div>
            </div>
        </div>

    </body>
</html>