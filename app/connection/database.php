<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/residencial/app/config/settings.php';
settings::load();

class database {
    private $host;
    private $database;
    private $user;
    private $pass;

    public function __construct() {
        $this->host = getenv("HOST");
        $this->database = getenv("DATABASE");
        $this->user = getenv("USER");
        $this->pass = getenv("PASS");
    }

    public function getConnection() {
        try {    
            $dsn = "mysql:host={$this->host};dbname={$this->database};charset=utf8mb4";
            $pdo = new PDO($dsn, $this->user, $this->pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            return $pdo;
        } catch (PDOException $ex) {
            throw $ex;
        }
    }
    
}
?>
