<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/residencial/app/config/settings.php';
settings::load();

class database {

    protected function getConnection() {
        try {    
            $pdo = new PDO($_ENV["DSN"], $_ENV["USER"], $_ENV["PASS"]);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            return $pdo;
        } catch (PDOException $ex) {
            throw $ex;
        }
    }
}
