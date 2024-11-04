<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/residencial/app/connection/database.php';

class userDAO extends database {
    private $db;

    function __construct() {
        $this->db = new database();
    }

    public function checkuser($username, $email){
        try {
            $con = $this->getConnection();
            $stmt = $con->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function create($username, $email, $password) {
        try {
            if (!$this->checkuser($username, $email)) {
                $con = $this->getConnection();
                $stmt = $con->prepare("INSERT INTO users (username, email, pass) VALUES (:username, :email, :pass)");
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':pass', password_hash($password, PASSWORD_DEFAULT));
                $stmt->execute();
                return true;
            } else {
                return false;
            }
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function findByEmail($email) {
        try {  
            $con = $this->getConnection();  
            $stmt = $con->prepare("SELECT * FROM users WHERE email = :email");  
            $stmt->bindParam(':email', $email);  
            $stmt->execute();  
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;  
        } catch (\PDOException $ex) {  
            throw $ex;
        } 
    }
}
?>
