<?php
class TeamController
{
    private $teamModel;
    private $teamView;

    // Constructor que recibe el modelo y la vista
    public function __construct($teamModel, $teamView)
    {
        $this->teamModel = $teamModel;
        $this->teamView = $teamView;
    }

    // Función para obtener los equipos y renderizar
    public function getTeams()
    {
        // Obtener todos los equipos desde el modelo
        $teams = $this->teamModel->getAllTeams();
        $this->teamView->render($teams,'getAllTeams');
    }

    // Función para obtener los equipos
    public function getTeamsObject()
    {
        // Obtener todos los equipos desde el modelo
        $teams = $this->teamModel->getAllTeams();
        return $teams;
    }
    
    // Función para obtener un equipo a partir del id
    // En entornos de producción se deberá pasar un uuid en lugar de un id
    public function getTeamById($id, $captains)
    {
        // Obtener todos el equipo a través del id
        $teams = $this->teamModel->getTeamById($id, $captains);
        $this->teamView->render($teams,'getTeamById',$captains);
    }

    // Método para agregar un equipo
    public function addTeamFromAjax($postData)
    {
        $teamName = $postData['teamName'];
        $teamCity = $postData['teamCity'];
        $teamSport = $postData['teamSport'];
        $teamFoundationDate = $postData['teamFoundationDate'];

        // Llamar al método del modelo para agregar el equipo
        $response = $this->teamModel->addTeam($teamName, $teamCity, $teamSport, $teamFoundationDate);

        // Respuesta
        echo json_encode($response);
        exit;
    }

    // Método para obtener los capitanes
    public function getCaptains($teamId){
        $teams = $this->teamModel->getCaptainsDB($teamId);
        return $teams;
    }

}
