<?php
class DatabaseMySQLi {
    private static $instance = null;
    private $conn;

    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $db   = 'advancedb';

    // 👇 Private constructor to prevent external instantiation
    private function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);

        // Check for connection errors
        if ($this->conn->connect_error) {
            die("MySQLi Connection failed: " . $this->conn->connect_error);
        }
    }

    // ✅ Singleton accessor method
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new DatabaseMySQLi();
        }
        return self::$instance;
    }

    // 💡 Query runner with prepared statement support
    public function query($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        // Dynamically bind parameters if present
        if (!empty($params)) {
            $types = str_repeat('s', count($params)); // assumes all strings for simplicity
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
}
?>
