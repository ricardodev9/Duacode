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

    // Función para obtener los equipos
    public function getTeams()
    {
        // Obtener todos los equipos desde el modelo
        $teams = $this->teamModel->getAllTeams();

        // Cargar la vista con los equipos
        $this->teamView->render($teams,'getAllTeams');
    }

    // Función para obtener un equipo a partir del id
    // En entornos de producción se deberá pasar un uuid en lugar de un id
    public function getTeamById($id)
    {
        // Obtener todos los equipos desde el modelo
        $teams = $this->teamModel->getTeamById($id);

        // Cargar la vista con los equipos
        $this->teamView->render($teams,'getTeamById');
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

        // Responder con un mensaje JSON
        echo json_encode($response);
        exit;
    }
}
