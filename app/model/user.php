<?php  
require_once './app/connection/database.php';  

class user extends Database  
{  
    private $id;  
    private $username;  
    private $email;  
    private $pass;  
    private $rol;  

    private function setPass($password)  
    {  
        if ($password) {  
            // Verificar si la contraseña es un hash de bcrypt  
            if (preg_match('/^\$2[ayb]\$.{56}$/', $password)) {  
                return $password;  
            }  
            return password_hash($password, PASSWORD_DEFAULT);  
        }  
        return null;  
    }  

    public function __construct($id = null, $username = null, $email = null, $pass = null, $rol = null)  
    {  
        $this->id = $id;  
        $this->username = $username;  
        $this->email = $email;  
        $this->pass = $this->setPass($pass);  
        $this->rol = $rol;  
    }  

    public function verifyPassword($password): bool  
    {  
        return password_verify($password, $this->pass);  
    }  

    public function getId()  
    {  
        return $this->id;  
    }  

    public function getUsername()  
    {  
        return $this->username;  
    }  

    public function getEmail()  
    {  
        return $this->email;  
    }  

    public function getPass()
    {  
        return $this->pass;  
    }  

    public function getRol()  
    {  
        return $this->rol;  
    }  

    private function checkUserExists($username, $email)  
    {  
        try {  
            $con = $this->getConnection();  
            $stmt = $con->prepare("SELECT * FROM users WHERE username = :username OR email = :email");  
            $stmt->bindParam(":username", $username);  
            $stmt->bindParam(":email", $email);  
            $stmt->execute();  
            return $stmt->fetch(PDO::FETCH_ASSOC);  
        } catch (\Throwable $th) {  
            error_log("Error checking user existence: " . $th->getMessage());  
            throw new Exception("Error checking user existence.");  
        }  
    }  

    public function create(User $user): bool  
    {  
        try {  
            if (!$this->checkUserExists($user->getUsername(), $user->getEmail())) {  
                $con = $this->getConnection();  
                $stmt = $con->prepare("INSERT INTO users (username, email, pass) VALUES (:username, :email, :pass)");  

                $username = $user->getUsername();
                $email = $user->getEmail();
                $pass = $user->getPass();

                $stmt->bindParam(':username', $username);  
                $stmt->bindParam(':email', $email);  
                $stmt->bindParam(':pass', $pass);

                $stmt->execute();  
                return true;  
            } else {  
                return false; 
            }  
        } catch (\PDOException $ex) {  
            error_log("Error creating user: " . $ex->getMessage());  
            throw new Exception("Error creating user.");  
        }  
    }  

    public function findByEmail($email): ?User  
    {  
        try {  
            $con = $this->getConnection();  
            $stmt = $con->prepare("SELECT * FROM users WHERE email = :email");  
            $stmt->bindParam(':email', $email);  
            $stmt->execute();  
            $responce = $stmt->fetch(PDO::FETCH_ASSOC);  
            return $responce ?  
                new User(  
                    $responce["id"],  
                    $responce["username"],  
                    $responce["email"],  
                    $responce["pass"],  
                    $responce["rol"]  
                ) : null;  
        } catch (\PDOException $ex) {  
            error_log("Error finding user by email: " . $ex->getMessage());  
            throw new Exception("Error finding user by email.");  
        }  
    }  
}