<?php
require_once './vendor/autoload.php';

use Dotenv\Dotenv;

// Cargar variables de entorno desde .env
Dotenv::createImmutable(__DIR__)->load();

// Exponer únicamente la variable DOMAIN
header('Content-Type: application/json');
echo json_encode(['domain' => $_ENV['DOMAIN'] ?? '']);
