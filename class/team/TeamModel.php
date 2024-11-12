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

        // Devolver los resultados como un array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para obtener todos los equipos desde la base de datos
    // En entornos de producción se deberá pasar un uuid en lugar de un id

    public function getTeamById($id) {
        // SQL para obtener un equipo específico utilizando un id
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id"; 
        
        // Preparar la consulta
        $stmt = $this->db->prepare($query);
        
        // Enlazar el parámetro :id para evitar inyecciones SQL
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);  // O PDO::PARAM_STR si el id es un UUID
        
        // Ejecutar la consulta
        $stmt->execute();

        // Devolver el resultado como un array asociativo (solo un equipo, no fetchAll)
        return $stmt->fetch(PDO::FETCH_ASSOC);  // Cambiar a fetch para obtener un solo resultado
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
}

?>