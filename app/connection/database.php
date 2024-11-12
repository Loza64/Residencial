<?php
require_once './app/config/settings.php';

class Database
{
    protected function getConnection(): PDO
    {
        $config = new Settings();
        try {
            $pdo = new PDO($config->getDsn(), $config->getUser(), $config->getPass());
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $ex) {
            throw $ex;
        }
    }
}
