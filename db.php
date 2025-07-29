<?php
class Database {
    private $host     = '127.0.0.1';
    private $db_name  = 'schoolstore_db';
    private $username = 'root';
    private $password = '';
    public  $conn;

    public function getConnection() {
        // Only connect once
        if ($this->conn === null) {
            try {
                $this->conn = new PDO(
                    "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4",
                    $this->username,
                    $this->password
                );
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Connection error: " . $e->getMessage();
                exit;
            }
        }
        return $this->conn;
    }

    public function query($sql, $params = []) {
        // Ensure connection is open
        if ($this->conn === null) {
            $this->getConnection();
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}
