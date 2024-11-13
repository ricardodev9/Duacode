<?php

class PlayerModel
{
    private $db;
    private $table = 'players';
    // Constructor que recibe la conexión a la base de datos
    public function __construct($db)
    {
        $this->db = $db;
    }

    // Método para obtener todos los jugadores desde la base de datos
    public function getAllPlayers()
    {
        // SQL para obtener todos los jugadores
        $query = "SELECT * FROM " . $this->table;

        // Preparar y ejecutar la consulta para evitar inyecciones
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        // Devolver los resultados como un array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para obtener todos los jugadores de un equipo específico desde la base de datos 
    public function getAllPlayersByTeam($id_team)
    {
        // SQL para seleccionar jugadores del equipo específico
        $query = "SELECT * FROM players WHERE team_id = :id_team";

        $stmt = $this->db->prepare($query);
        // Asignar el parámetro
        $stmt->bindParam(':id_team', $id_team, PDO::PARAM_INT);
        $stmt->execute();

        // Obtener y devolver los resultados como un array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para obtener un jugador 
    // En entornos de producción se deberá pasar un uuid en lugar de un id
    public function getPlayerById($id)
    {
        // SQL para obtener un equipo específico utilizando un id
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";

        // Preparar la consulta
        $stmt = $this->db->prepare($query);

        // Enlazar el parámetro :id para evitar inyecciones SQL
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para actualizar un jugador
    public function updatePlayerDB($playerId, $name, $number, $teamId, $isCaptain)
    {
        try {
            // Verificar si el número ya está en uso en el mismo equipo
            if ($this->isPlayerNumberExist($number, $teamId, $playerId)) {
                return ['status' => 'error', 'msg' => 'El número de jugador ya está registrado en este equipo.'];
            }
            $query = "UPDATE " . $this->table . " SET name = :name, number = :number, team_id = :team_id, is_captain = :is_captain WHERE id = :id";
            $stmt = $this->db->prepare($query);

            // Asocia los valores a los parámetros de la consulta
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':number', $number);
            $stmt->bindParam(':team_id', $teamId);
            $stmt->bindParam(':id', $playerId);
            $stmt->bindParam(':is_captain', $isCaptain);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                return ['status' => 'success', 'msg' => 'Jugador actualizado con éxito'];
            } else {
                return ['status' => 'error', 'msg' => 'Hubo un error al actualizar el jugador'];
            }
        } catch (PDOException $e) {
            return ['status' => 'error', 'msg' => 'Error al actualizar el jugador: ' . $e->getMessage()];
        }
    }

    // Método para obtener el nombr del equipo
    public function getTeamNameById($teamId)
    {
        $query = "SELECT name FROM teams WHERE id = :team_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':team_id', $teamId);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['name'] : 'Equipo desconocido'; // Devuelve el nombre del equipo o un mensaje si no existe
    }

    // Método para eliminar un jugador
    public function deletePlayerDB($playerId)
    {
        // Verificar si el ID del jugador es válido
        if (empty($playerId) || !is_numeric($playerId)) {
            return false; 
        }
        try {
            // Preparar la consulta SQL para eliminar el jugador por ID
            $query = "DELETE FROM players WHERE id = :playerId";

            // Preparar la declaración PDO
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':playerId', $playerId, PDO::PARAM_INT);
            $stmt->execute();

            // Verificar si la eliminación fue exitosa
            if ($stmt->rowCount() > 0) {
                return ['status' => 'success', 'msg' => 'Jugador eliminado correctamente.'];
            } else {
                return ['status' => 'error', 'msg' => 'No se pudo eliminar el jugador. Intenta de nuevo.'];
            }
        } catch (PDOException $e) {
            return ['status' => 'error', 'msg' => 'Error al eliminar el jugador: ' . $e->getMessage()];
        }
    }

    // Método para agrear un nuevo jugador
    public function addPlayerDB($name, $number, $team, $captain)
    {
        // Validar los datos
        if (empty($name) || empty($number) || empty($team)) {
            return ['status' => 'error', 'msg' => 'Todos los campos son obligatorios.'];
        }

        // Verificar si el número ya está en uso en el mismo equipo
        if ($this->isPlayerNumberExist($number, $team)) {
            return ['status' => 'error', 'msg' => 'El número de jugador ya está registrado en este equipo.'];
        }

        // Preparar la consulta para insertar los datos en la base de datos
        try {
            $query = "INSERT INTO players (name, number, team_id, is_captain) VALUES (:name, :number, :team, :captain)";
            $stmt = $this->db->prepare($query);

            // Asignar los valores a los parámetros
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':number', $number);
            $stmt->bindParam(':team', $team);
            $stmt->bindParam(':captain', $captain);

            // Ejecutar la consulta
            $stmt->execute();

            // Comprobar si se insertó correctamente
            if ($stmt->rowCount() > 0) {
                return ['status' => 'success', 'msg' => 'Jugador añadido correctamente.'];
            } else {
                return ['status' => 'error', 'msg' => 'No se pudo agregar el jugador. Intenta de nuevo.'];
            }
        } catch (PDOException $e) {
            // Manejar errores de la base de datos
            return json_encode(['status' => 'error', 'msg' => 'Error al agregar el jugador: ' . $e->getMessage()]);
        }
    }

    // Método para verificar si el número de jugador ya está en uso dentro del equipo, excluyendo el jugador actual
    public function isPlayerNumberExist($number, $teamId, $playerId = null)
    {
        // Preparar la consulta para verificar si el número ya existe en el equipo, excluyendo al jugador con el ID $playerId
        $query = "SELECT COUNT(*) FROM players WHERE number = :number AND team_id = :teamId";

        // Añadimos una condición para excluir ese jugador
        if ($playerId) {
            $query .= " AND id != :playerId";
        }

        $stmt = $this->db->prepare($query);

        // Asignar los parámetros
        $stmt->bindParam(':number', $number);
        $stmt->bindParam(':teamId', $teamId);

        if ($playerId) {
            $stmt->bindParam(':playerId', $playerId);
        }

        $stmt->execute();
        
        return $stmt->fetchColumn() > 0;
    }
}
