<?php
define('BASE_PATH', dirname(__FILE__));

// Cargar el autoloader
require_once BASE_PATH . '/autoload.php'; 

// Crear una instancia de la clase Database para manejar la conexión a la base de datos
$database = new Database();
$db = $database->connect();

//si hubo algún error, mostrará este mensaje
if(!$db){
    die("<p>Importa el archivo .sql de la raíz del proyecto a la BBDD</p>");
}

// Crear una instancia de los modelos y las vistas
$teamModel = new TeamModel($db);  
$teamView = new TeamView(); 
$playerModel = new PlayerModel($db); 
$playerView = new PlayerView();

// Crear instancias de los controladores y pasarles sus respectivos modelos y vistas
$teamController = new TeamController($teamModel, $teamView);  
$playerController = new PlayerController($playerModel, $playerView);  


?>
