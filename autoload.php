<?php
/**
 * Importar las clases necesarias
 */
spl_autoload_register(function ($class_name) {
    $class_name = str_replace('\\', '/', $class_name);  
    $file = BASE_PATH . '/class/team/' . $class_name . '.php';
    $file2 = BASE_PATH . '/class/player/' . $class_name . '.php';
    $fileDB = BASE_PATH . '/class/DB.php';
    if (file_exists($file)) {
        require_once $file;
    }
    if(file_exists($fileDB)){
        require_once BASE_PATH . '/class/DB.php';
    }
    if(file_exists($file2)){
        require_once $file2;
    }
});

?>