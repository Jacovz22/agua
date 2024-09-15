<?php 
// Incluir el autoload de Composer
require __DIR__ . '/../Library/vendorEnv/vendor/autoload.php';

use Dotenv\Dotenv;

// Cargar las variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Obtener los valores de las variables de entorno
$entorno = $_ENV['APP_ENV'] ?? null;
$host = $_ENV['DB_HOST'] ?? null;
$port = $_ENV['DB_PORT'] ?? null;
$user = $_ENV['DB_USER'] ?? null;
$password = null;
$BD = null;

switch ($entorno) {
    case 'development':
        $password = $_ENV['DBD_PASSWORD'] ?? null;
        $BD = $_ENV['DBD_NAME'] ?? null;
        break;
    case 'test':
        $password = $_ENV['DBT_PASSWORD'] ?? null;
        $BD = $_ENV['DBT_NAME'] ?? null;
        break;
    case 'production':
        $password = $_ENV['DBP_PASSWORD'] ?? null;
        $BD = $_ENV['DBP_NAME'] ?? null;
        break;
}


?>