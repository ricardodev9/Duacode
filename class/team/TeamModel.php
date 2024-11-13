<?php

class TeamModel {
    private $db;
    private $table = 'teams';

    // Constructor que recibe la conexión a la base de datos
    public function __construct($db) {
        $this->db = $db;
    }

    // Método para obtener todos los equipos desde la base de datos
    public function getAllTeams() {
        // SQL para obtener todos los equipos
        $query = "SELECT * FROM " .$this->table; 
        // Preparar y ejecutar la consulta para evitar inyecciones
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para obtener el equipo a través del ID 
    // En entornos de producción se deberá pasar un uuid en lugar de un id
    public function getTeamById($id) {
        // SQL para obtener un equipo específico utilizando un id
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id"; 
        
        // Preparar la consulta
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }


    // Método para agregar un nuevo equipo
    public function addTeam($teamName, $teamCity, $teamSport, $teamFoundationDate) {
        try {
            // Consulta SQL para insertar un nuevo equipo
            $query = "INSERT INTO " . $this->table . " (name, city, sport, foundation_date) 
                      VALUES (:name, :city, :sport, :foundation_date)";
    
            // Preparar la consulta
            $stmt = $this->db->prepare($query);
    
            // Vincular los valores
            $stmt->bindParam(':name', $teamName);
            $stmt->bindParam(':city', $teamCity);
            $stmt->bindParam(':sport', $teamSport);
            $stmt->bindParam(':foundation_date', $teamFoundationDate);
    
            // Ejecutar la consulta
            if ($stmt->execute()) {
                return ['status' => 'success', 'msg' => 'Equipo agregado con éxito'];
            } else {
                return ['status' => 'error', 'msg' => 'Hubo un error al agregar el equipo'];
            }
        } catch (PDOException $e) {
            return ['status' => 'error', 'msg' => 'Error al agregar el Equipo: ' . $e->getMessage()]; 
        }
    }
    
    // Método para obtener todos los capitanes
    public function getCaptainsDB($teamId)
    {
        // Preparar la consulta SQL para seleccionar todos los jugadores que son capitanes
        $query = "SELECT id, name, number, team_id FROM players WHERE team_id = :teamId AND is_captain = 1 ";
        // Preparar la consulta
        $stmt = $this->db->prepare($query);

        // Asignar los parámetros
        $stmt->bindParam(':teamId', $teamId);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener todos los resultados
        return $stmt->fetchAll(PDO::FETCH_ASSOC);   
    }
}

?>