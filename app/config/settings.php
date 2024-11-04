<?php  
require_once $_SERVER['DOCUMENT_ROOT'] . '/residencial/vendor/autoload.php';

use Dotenv\Dotenv;

class settings {
    public static function load() {
        $dotenv = Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT'] . '/residencial');
        $dotenv->load();
    }
}

?>