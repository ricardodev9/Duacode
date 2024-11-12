<?php

class Database {
    private $host = 'localhost';
    private $dbname = 'sports_management';  // Cambia el nombre de la base de datos si es necesario
    private $username = 'root';  // Cambia el usuario si es necesario
    private $password = '';  // Cambia la contraseña si es necesario
    public $conn;

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
        return $this->conn;
    }
}

?>
