<?php

// Define la constante BASE_PATH para la ruta base de la aplicación
define('BASE_PATH', dirname(__FILE__)); // Asegura que la ruta base se establezca correctamente.

// Cargar el autoloader
require_once BASE_PATH . '/autoload.php';  // Cargar el autoloader

// Crear una instancia de la clase Database para manejar la conexión a la base de datos
$database = new Database();
$db = $database->connect();

// Crear una instancia del modelo y la vista
$teamModel = new TeamModel($db);  // Instancia del modelo
$teamView = new TeamView();  // Instancia de la vista

// Crear una instancia del controlador y pasarle el modelo y la vista
$teamController = new TeamController($teamModel, $teamView);  // Ahora se pasan ambos parámetros

?>
