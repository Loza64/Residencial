<?php
require_once './app/connection/database.php';

class user extends database
{
    private $id;  
    private $username;  
    private $email;  
    private $pass;  
    private $rol;  
 
    public function __construct() {  
        $this->id = null;  
        $this->username = null;  
        $this->email = null;  
        $this->pass = null;  
        $this->rol = null;  
    }  

    public function __constructFull($id, $username, $email, $pass, $rol) {  
        $this->id = $id;  
        $this->username = $username;  
        $this->email = $email;  
        $this->pass = $pass;  
        $this->rol = $rol;  
    }  

    public function getId() {  
        return $this->id;  
    }  

    public function getUsername() {  
        return $this->username;  
    }  

    public function getEmail() {  
        return $this->email;  
    }  

    public function getPass() {  
        return $this->pass;  
    }  

    public function getRol() {  
        return $this->rol;  
    }  

    private function checkuser($username, $email)
    {
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

    public function create(user $user): bool
    {
        try {
            if (!$this->checkuser($user->getUsername(), $user->getEmail())) {
                $con = $this->getConnection();
                $stmt = $con->prepare("INSERT INTO users (username, email, pass) VALUES (:username, :email, :pass)");

                $username = $user->getUsername();
                $email = $user->getEmail();
                $pass  = $user->getPass();

                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':pass', $pass);
                $stmt->execute();
                return true;
            } else {
                return false;
            }
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function findByEmail($email): ?user
    {
        try {
            $con = $this->getConnection();
            $stmt = $con->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $responce = $stmt->fetch(PDO::FETCH_ASSOC);
            return $responce ?
                new user(
                    $responce["id"],
                    $responce["username"],
                    $responce["email"],
                    $responce["pass"],
                    $responce["rol"]
                ) : null;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }
}
