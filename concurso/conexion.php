<?php 
class Database {
    private $host = 'localhost';
    private $dbname = 'concurso';
    private $port = '3306';
    private $username = 'root';
    private $password = '';
    protected $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname};port={$this->port};charset=utf8", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Ocurrio un error " . $e->getMessage();
        }
        return $this->conn;
    }
}
?>