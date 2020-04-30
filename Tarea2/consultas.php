<?php

/**
 * Limpia los strings
 */
function limpiar($db, $str){
	return htmlspecialchars($db->real_escape_string($str));
}


/**
 * Entrega el id de la region, $region es un string.
 */
function getRegionId($db, $region){
    $get_region_id = $db->prepare("SELECT * FROM region WHERE nombre=?");   
    $get_region_id->bind_param('s', $region);
    $get_region_id->execute();
    $get_region_id_result = $get_region_id->get_result();
    
    return $get_region_id_result->fetch_row()[0];
}

function getComunaId($db, $id_region, $comuna){
    $get_comuna_id = $db->prepare("SELECT * FROM comuna WHERE nombre=? AND region_id=?");
    $get_comuna_id->bind_param('si', $comuna, $id_region);
    $get_comuna_id->execute(); 
    $get_comuna_id_result = $get_comuna_id->get_result();

    return $get_comuna_id_result->fetch_row()[0];
}

function insertMedico($db ,$nombre, $experiencia, $comuna_id, $twitter, $email, $celular){
    $nombre = limpiar($db, $nombre);
    $experiencia = limpiar($db, $experiencia);
    $twitter = limpiar($db, $twitter);
    $email = limpiar($db, $email);

    $insert_medico = $db->prepare("INSERT INTO medico (nombre, experiencia, comuna_id, twitter, email, celular) VALUES (?,?,?,?,?,?)");
    $insert_medico->bind_param("ssisss", $nombre, $experiencia, $comuna_id, $twitter, $email, $celular);

    $result = $insert_medico->execute();

    return $result;
}


function insertEspecialidadesMedico($db, $id_medico, $especialidades){
    $result;
    foreach($especialidades as $especialidad){
        $insert_especialidades_medico = $db->prepare("INSERT INTO especialidad_medico (medico_id, especialidad_id) VALUES (?,?)");
        $insert_especialidades_medico->bind_param("ii", $id_medico, $especialidad);
        $result = $insert_especialidades_medico->execute();
    }
    return $result;
}

function insertImagesMedico($db, $id_medico, $images_array){
    $upload_dir = './upload_files/medicos';
    $result = 0;
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    foreach($images_array["error"] as $key => $error){
        if ($error == UPLOAD_ERR_OK) {
            $tmp_name = $images_array["tmp_name"][$key];
            $name = $images_array["name"][$key];
            $new_dir = "$upload_dir/$id_medico$key$name";
            if(!move_uploaded_file($tmp_name, $new_dir)){
                return 0;
            }
            $insert_image = $db->prepare("INSERT INTO foto_medico (ruta_archivo, nombre_archivo, medico_id) VALUES (?,?,?)");
            $insert_image->bind_param("ssi", $new_dir, $name, $id_medico);
            $result = $insert_image->execute();
        }
    }
    return $result;
}

function insertSolicitud($db, $nombre, $especialidad, $sintomas, $twitter, $email, $celular, $comuna_id){
    $nombre = limpiar($db, $nombre);
    $sintomas = limpiar($db, $sintomas);
    $twitter = limpiar($db, $twitter);
    $email = limpiar($db, $email);

    $insert_medico = $db->prepare("INSERT INTO solicitud_atencion (nombre_solicitante, especialidad_id, sintomas, twitter, email, celular, comuna_id) VALUES (?,?,?,?,?,?,?)");
    $insert_medico->bind_param("sissssi", $nombre, $especialidad, $sintomas, $twitter, $email, $celular, $comuna_id);

    $result = $insert_medico->execute();

    return $result;
}


function insertFilesSolicitante($db, $id_solicitud, $files){
    $upload_dir = './upload_files/solicitantes';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    $result = 1;
    foreach($files["error"] as $key => $error){
        if ($error == UPLOAD_ERR_OK) {
            $tmp_name = $files["tmp_name"][$key];
            $name = $files["name"][$key];
            $new_dir = "$upload_dir/$id_solicitud$key$name";
            $mimetype = $files["type"][$key];
            if(!move_uploaded_file($tmp_name, $new_dir)){
                return 0;
            }
            $insert_file = $db->prepare("INSERT INTO archivo_solicitud (ruta_archivo, nombre_archivo, mimetype, solicitud_atencion_id) VALUES (?,?,?,?)");
            $insert_file->bind_param("sssi", $new_dir, $name, $mimetype, $id_solicitud);
            $result = $insert_file->execute();
        }
    }
    return $result;
}


function getMedicosData($db, $offset){
    $medicos_data = $db->prepare("SELECT id, nombre, experiencia, comuna_id, twitter, email, celular FROM medico ORDER BY id DESC LIMIT 5 OFFSET ?");
    $medicos_data->bind_param('i', $offset);
    $medicos_data->execute();

    return $medicos_data->get_result();
}


function getEspecialidadesMedico($db, $id_medico){
    $especialidades_medico = $db->prepare("SELECT especialidad.descripcion FROM especialidad, especialidad_medico WHERE especialidad_medico.medico_id=? AND especialidad.id=especialidad_medico.especialidad_id");
    $especialidades_medico->bind_param('i', $id_medico);
    $especialidades_medico->execute();

    return $especialidades_medico->get_result();
}

function getComunaRegionById($db, $id_comuna){
    $comuna = $db->prepare("SELECT comuna.nombre as nombre_comuna, region.nombre as region_nombre FROM comuna, region WHERE comuna.id=? AND region.id=comuna.region_id");
    $comuna->bind_param('i', $id_comuna);
    $comuna->execute();

    return $comuna->get_result();
}

function numberOfPages($db){
    $medicos_data = $db->prepare("SELECT COUNT(*) as number FROM medico");
    $medicos_data->execute();

    return ceil((($medicos_data->get_result()->fetch_assoc()["number"])/5));
}

function numberOfPagesSolicitudes($db){
    $medicos_data = $db->prepare("SELECT COUNT(*) as number FROM solicitud_atencion");
    $medicos_data->execute();

    return ceil((($medicos_data->get_result()->fetch_assoc()["number"])/5));
}

function getSolicitudesData($db, $offset){
    $solicitudes_data = $db->prepare("SELECT id, nombre_solicitante, especialidad_id, sintomas, twitter, email, celular, comuna_id FROM solicitud_atencion ORDER BY id DESC LIMIT 5 OFFSET ?");
    $solicitudes_data->bind_param('i', $offset);
    $solicitudes_data->execute();

    return $solicitudes_data->get_result();
}

function getEspecialidadSolicitante($db, $id){
    $especialidades_medico = $db->prepare("SELECT descripcion FROM especialidad WHERE id=?");
    $especialidades_medico->bind_param('i', $id);
    $especialidades_medico->execute();

    return $especialidades_medico->get_result();
}

function getMedicoDataById($db, $id){
    $medicos_data = $db->prepare("SELECT id, nombre, experiencia, comuna_id, twitter, email, celular FROM medico WHERE id=?");
    $medicos_data->bind_param('i', $id);
    $medicos_data->execute();

    return $medicos_data->get_result();
}

function getImagesById($db, $id){
    $medico_images = $db->prepare("SELECT ruta_archivo FROM foto_medico WHERE medico_id=?");
    $medico_images->bind_param('i', $id);
    $medico_images->execute();

    return $medico_images->get_result();
}

function getSolicitudDataById($db, $id){
    $solicitudes_data = $db->prepare("SELECT id, nombre_solicitante, especialidad_id, sintomas, twitter, email, celular, comuna_id FROM solicitud_atencion WHERE id=?");
    $solicitudes_data->bind_param('i', $id);
    $solicitudes_data->execute();

    return $solicitudes_data->get_result();
}

function getFilesById($db, $id){
    $files = $db->prepare("SELECT ruta_archivo, nombre_archivo, mimetype FROM archivo_solicitud WHERE solicitud_atencion_id=?");
    $files->bind_param('i', $id);
    $files->execute();

    return $files->get_result();
}
?>