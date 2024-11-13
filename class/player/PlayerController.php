<?php
class PlayerController
{
    private $playerModel;
    private $playerView;

    // Constructor que recibe el modelo y la vista
    public function __construct($playerModel, $playerView)
    {
        $this->playerModel = $playerModel;
        $this->playerView = $playerView;
    }

    // Obtener todos los jugadores
    public function getPlayers()
    {
        // Obtener todos los equipos desde el modelo
        $players = $this->playerModel->getAllPlayers();

        // Cargar la vista con los equipos
        $this->playerView->render($players);
    }

    public function getPlayersByTeam($idTeam){
        // Obtener todos los equipos desde el modelo
        $players = $this->playerModel->getAllPlayersByTeam($idTeam);

        // Cargar la vista con los equipos
        $this->playerView->render($players,'getAllPlayersByTeam');
    }

    public function getPlayerById($idPlayer,$teams){
        // Obtener el jugador
        $player = $this->playerModel->getPlayerById($idPlayer); 
        if ($player) {
            // Guardar el nombre del equipo en el array
            $player['team_name'] = $this->playerModel->getTeamNameById($player['team_id']);
        }
    
        // Verificar si 'team_name' se asignó correctamente
        if (!isset($player['team_name'])) {
            $player['team_name'] = 'Equipo no encontrado';
        }

        //Cargar vista
        $this->playerView->render($player,'getPlayerById',$teams);
    }

    // Método para actualizar un jugador
    public function updatePlayer($playerId, $name, $number, $teamId, $isCaptain) {
        $response = $this->playerModel->updatePlayerDB($playerId, $name, $number, $teamId, $isCaptain);
        echo json_encode($response); 
    }

    // Método para eliminar un jugador
    public function deletePlayer($playerId){
        $response = $this->playerModel->deletePlayerDB($playerId);
        echo json_encode($response); 
    }

    //Método para agregar un jugador
    public function addPlayer($name,$number,$teamId,$isCaptain) {
        // Llamar al modelo para agregar el jugador
        $response = $this->playerModel->addPlayerDB($name, $number, $teamId, $isCaptain);
        echo json_encode($response); 
    }
}
?>