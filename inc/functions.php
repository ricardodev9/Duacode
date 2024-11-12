<?php
// Incluir autoloader si no se ha incluido ya en index.php o en otros archivos
require_once __DIR__ . '/../autoload.php'; 
require_once __DIR__ . '/../config.php';  

// Verificar si la solicitud es de tipo POST y si el parámetro 'method' es 'add_team'
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['method']) && $_POST['method'] === 'add_team') {
    // Obtener los datos enviados por AJAX
    $teamName = $_POST['teamName'];
    $teamCity = $_POST['teamCity'];
    $teamSport = $_POST['teamSport'];
    $teamFoundationDate = $_POST['teamFoundationDate'];

    // Verificar que los datos necesarios han sido enviados
    if (!empty($teamName) && !empty($teamCity) && !empty($teamSport) && !empty($teamFoundationDate)) {
        // Instanciar el controlador y el modelo dentro de la función
        $teamController = new TeamController($teamModel,$teamView);  // Instancia de TeamController

        //Llamar al método del controlador para agregar el equipo
        $response = $teamController->addTeamFromAjax($_POST); 
        // Verificar si la respuesta es exitosa
        if ($response['status'] === 'success') {
            echo json_encode(['status' => 'success', 'msg' => 'Equipo añadido con éxito']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => $response['msg']]);
        }
    } else {
        // Si falta algún campo, devolver un error
        echo json_encode(['status' => 'error', 'msg' => 'All fields are required']);
    }

    exit;
}
?>
