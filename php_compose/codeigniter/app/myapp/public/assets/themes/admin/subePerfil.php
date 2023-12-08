<?php

//comprobamos que sea una petición ajax
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    // si hay algun archivo que subir
    if ($_FILES["archivoIm"]["name"]) {
        $ruta = "assets/files/perfiles/";

        //for($i=0;$i<count($_FILES["archivoIm"]["name"]);$i++){
        //obtenemos el archivo a subir
        $corr = rand(500, 1000000);
        $file = $_FILES['archivoIm']['name'];
        
        $file = $corr.$file;

        //comprobamos si existe un directorio para subir el archivo
        //si no es así, lo creamos
        if (!is_dir($ruta)) {
            mkdir($ruta, 0777);
        }
        //comprobamos si el archivo ha subido
        if (move_uploaded_file($_FILES['archivoIm']['tmp_name'], $ruta . $file)) {
            sleep(3); //retrasamos la petición 3 segundos
            echo $file; //devolvemos el nombre del archivo para pintar la imagen
        }
        // }
    } else {
        
    }
} else {
    throw new Exception("Error Processing Request", 1);
}