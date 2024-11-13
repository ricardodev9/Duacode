<?php
require_once __DIR__ . '/../autoload.php';
require_once __DIR__ . '/../config.php';

// Añadir equipo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['method']) && $_POST['method'] === 'add_team') {
    // Obtener los datos enviados por AJAX
    $teamName = $_POST['teamName'];
    $teamCity = $_POST['teamCity'];
    $teamSport = $_POST['teamSport'];
    $teamFoundationDate = $_POST['teamFoundationDate'];

    // Verificar que los datos necesarios han sido enviados
    if (!empty($teamName) && !empty($teamCity) && !empty($teamSport) && !empty($teamFoundationDate)) {
        // Instanciar el controlador y el modelo dentro de la función
        $teamController = new TeamController($teamModel, $teamView); 
        //Llamar al método del controlador para agregar el equipo
        $response = $teamController->addTeamFromAjax($_POST);
        exit;
    } else {
        echo json_encode(['status' => 'error', 'msg' => 'All fields are required']);
    }
    
    exit;
}

// Actualizar jugador
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['method']) && $_POST['method'] === 'update_player') {
    // Sanitizar y validar datos recibidos
    $playerId = $_POST['playerId'];
    $name = $_POST['name'];
    $number = trim($_POST['number']);
    $team = $_POST['team'];
    $is_captain = $_POST['is_captain'];

    // Validar los campos y devolver error si están vacíos
    if (empty($name) || empty($number) || empty($team)) {
        echo json_encode(['status' => 'error', 'msg' => 'Todos los campos son obligatorios.']);
        exit;
    }
    
    //Llamar al método del controlador para actualizar el equipo
    $updated = $playerController->updatePlayer($playerId, $name, $number, $team, $is_captain);
    exit;
}

// Eliminar jugador
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['method']) && $_POST['method'] === 'delete_player' && isset($_POST['playerId'])) {
    // Sanitizar y validar datos recibidos
    $playerId = $_POST['playerId'];
    $result = $playerController->deletePlayer($playerId);
    exit;
}

// Añadir jugador
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['method']) && $_POST['method'] === 'add_player') {
    // Recoger los datos del formulario
    $name = $_POST['name'];
    $number = $_POST['number'];
    $team = $_POST['team'];
    $captain = $_POST['captain'];

    //Llamar al método del controlador para agregar el player
    $result = $playerController->addPlayer($name, $number, $team, $captain);
    exit;
}

?>
