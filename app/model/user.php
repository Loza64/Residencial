<?php
require_once './app/connection/database.php';

class User extends Database
{
    private $id;
    private $username;
    private $email;
    private $pass;
    private $rol;

    private function setPass($password)
    {
        if ($password) {
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

    private function checkUserExists(string $username, string $email, PDO $con)
    {
        try {
            $stmt = $con->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (\Throwable $th) {
            error_log("Error checking user existence: " . $th->getMessage());
            throw new Exception("Error checking user existence.");
        }
    }

    public function create(User $user): bool
    {
        try {
            $con = $this->getConnection();
            if (!$this->checkUserExists($user->getUsername(), $user->getEmail(), $con)) {
                $stmt = $con->prepare("INSERT INTO users (username, email, pass) VALUES (:username, :email, :pass)");
                $stmt->bindValue(':username', $user->getUsername());
                $stmt->bindValue(':email', $user->getEmail());
                $stmt->bindValue(':pass', $user->getPass());
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

    public function getUserList(?string $search): array
    {
        $user = [];
        try {
            $con = $this->getConnection();
            $stmt = $con->prepare("select id ,username, email, rol from users where username like concat('%',:search,'%') and rol != 's_admin'"
            );
            $stmt->bindParam(":search", $search);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($user, new User(
                    $row["id"],
                    $row["username"],
                    $row["email"],
                    null,
                    $row["rol"]
                ));
            }
            return $user;
        } catch (\Throwable $th) {
            error_log($th->getMessage());
            throw new Exception("Error to get user list");
        }
    }
}
