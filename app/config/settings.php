<?php  
require_once $_SERVER['DOCUMENT_ROOT'] . '/residencial/vendor/autoload.php';

class settings {  
    public static function load() {  
        $dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT'] . '/residencial/');
        $dotenv->load();
    }  
} 

?>