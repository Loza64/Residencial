<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/residencial/app/model/dao/userDAO.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/residencial/app/model/entities/user.php';

class controller{
    
    private $userdao;

    function __construct(){
        $this->userdao = new userDAO();
    }

    function login($email, $pass){
        try {
            $response = $this->userdao->findByEmail($email);
            if ($response && password_verify($pass, $response['pass'])) {
                return $response;
            } else {
                return null;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    function signUp($username, $email, $pass){
        try {
            $response = $this->userdao->create($username, $email, password_hash($pass, PASSWORD_DEFAULT));
            return $response;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

?>