<?php

spl_autoload_register(function ($class_name) {
    // Determinar la ruta del archivo de la clase, asumiendo que las clases están en /class/team o /class
    $class_name = str_replace('\\', '/', $class_name);  // Si utilizas namespaces
    $file = BASE_PATH . '/class/team/' . $class_name . '.php';
    $fileDB = BASE_PATH . '/class/DB.php';
    if (file_exists($file)) {
        require_once $file;
    }
    if(file_exists($fileDB)){
        require_once BASE_PATH . '/class/DB.php';
    }
});

?>