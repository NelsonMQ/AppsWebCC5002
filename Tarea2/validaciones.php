<?php

/**
 * Chequea que la region no sea vacia
 */
function checkRegion($post, $id){
    if(strlen($post[$id])<1){
        return false;
    }
    return true;
}


/**
 * Chequea que la comuna no sea vacia
 */
function checkComuna($post, $id){
    if(strlen($post[$id])<1){
        return false;
    }
    return true;
}


/*
 *Cheque que el nombre no contenga numeros, y que su largo este entre 30 y 1.
 */
function checkName($post, $id){
    if(isset($post[$id])){
		$regexp = "/^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/";
		if(!preg_match($regexp, $post[$id])){
			return false;
        }
        if(strlen($post[$id])<1){
            return false;
        }
        if(strlen($post[$id])>30){
            return false;
        }
        return true;
	}
	return false;
}


/*
 *Chequea que el largo del texto no sea mayor a 500.
 */
function checkInputTextBox($post, $id){
    if(isset($post[$id])){
        if(strlen($post[$id])>500){
            return false;
        }
        return true;
    }
    return false;
} 


/**
 * Chequea que las especialidades selecionadas no superen el max_len y que sea minimo 1
 */
function checkEspecialidades($post, $id, $max_len){
    if(isset($post[$id])){
        if(count($post[$id])>$max_len || count($post[$id])<1){
            return false;
        }
        return true;
    }
    return false;
}


/**
 * Chequea que la cantidad de fotos sea entre 1 y 5, y que tengan un formato de imagen
 */
function checkImagesFiles($files, $id){
    if(isset($files[$id])){
        $files_number = 0;

        for($i = 0;$i<count($files[$id]["name"]);$i++){
            if($files[$id]["error"][$i]==0){
                $files_number+=1;
            }
        }

        if($files_number> 5 || $files_number<1){
            return false;
        }

        for($i = 0;$i<count($files[$id]["name"]);$i++){
            if(strpos($files[$id]["type"][$i],"image")===false && $files[$id]["error"][$i]==0){
                return false;
            }
        }
        return true;
    }
}


/**
 * Chequea que el largo del twitter este entre 3 y 80, ademas de su formato. Tambien puede ser vacio.
 */
function checkTwitter($post, $id){
    if($post[$id]==""){
        return true;
    }
    if(strlen($post[$id])>80 || strlen($post[$id])<3){
        return false;
    }
    $regexp = "/^@(\w){1,15}$/";
    if(!preg_match($regexp, $post[$id])){
        return false;
    }
    return true;
}


/**
 * Chequea el formato de email, tambien puede ser vacio.
 */
function checkEmail($post, $id){
    if($post[$id]==""){
        return true;
    }
    $regexp = '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
    if(!preg_match($regexp, $post[$id])){
        return false;
    }
    return true;
}


/**
 * Chequea el formato del numero, tambien puede ser vacio.
 */
function checkNumero($post, $id){
    if($post[$id]==""){
        return true;
    }
    $regexp = '/^\+?([0-9]{2})\)?[-. ]?([0-9]{5})[-. ]?([0-9]{4})$/';
    if(!preg_match($regexp, $post[$id])){
        return false;
    }
    return true;
}

/**
 * Chequea que los archivos sean maximo 5, pueden ser 0 archivos.
 */
function checkFiles($files, $id){
    $files_number = 0;

    for($i = 0;$i<count($files[$id]["name"]);$i++){
        if($files[$id]["error"][$i]==0){
            $files_number+=1;
        }
    }

    if($files_number> 5){
        return false;
    }

    return true;
}


/**
 * Chequea los datos del medico
 */
function checkMedicoData($post){
    $errores = array();

    if(!checkRegion($post, "region-medico")){
        $errores[] = "Region: Formato invalido.";
    }

    if(!checkComuna($post, "comuna-medico")){
        $errores[] = "Comuna: Formato invalido.";
    }

    if(!checkName($post, "nombre-medico")){
        $errores[] = "Nombre: Formato invalido.";
    }

    if(!checkEmail($post, "email-medico")){
        $errores[] = "Email: Formato invalido.";
    }

    if(!checkTwitter($post, "twitter-medico")){
        $errores[] = "Twitter: Formato invalido.";
    }

    if(!checkNumero($post, "celular-medico")){
        $errores[] = "Numero: Formato invalido.";
    }

    if(!checkInputTextBox($post, "experiencia-medico")){
        $errores[] = "Experiencia: No debe superar 500 de tamaño.";
    }

    if(!checkEspecialidades($post, "especialidades-medico", 5)){
        $errores[] = "Especialidades: Maximo 5, minimo 1.";
    }
    return $errores;
}

/**
 * Chequea la informacion del solicitante
 */
function checkSolicitanteData($post){
    $errores = array();

    if(!checkRegion($post, "region-solicitante")){
        $errores[] = "Region: Formato invalido.";
    }

    if(!checkComuna($post, "comuna-solicitante")){
        $errores[] = "Comuna: Formato invalido.";
    }

    if(!checkName($post, "nombre-solicitante")){
        $errores[] = "Nombre: Formato invalido.";
    }

    if(!checkEmail($post, "email-solicitante")){
        $errores[] = "Email: Formato invalido.";
    }

    if(!checkTwitter($post, "twitter-solicitante")){
        $errores[] = "Twitter: Formato invalido.";
    }

    if(!checkNumero($post, "celular-solicitante")){
        $errores[] = "Numero: Formato invalido.";
    }

    if(!checkInputTextBox($post, "sintomas-solicitante")){
        $errores[] = "Experiencia: No debe superar 500 de tamaño.";
    }

    if(!checkEspecialidades($post, "especialidad-solicitud", 1)){
        $errores[] = "Especialidades: Maximo 5, minimo 1.";
    }
    return $errores;
}
?>