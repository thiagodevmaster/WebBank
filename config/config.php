<?php
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . "/..");
$dotenv->load();

// Configurações do Banco de Dados
define("DB_CONNECTION", $_ENV['DB_CONNECTION']);
define("DB_HOST", $_ENV['DB_HOST']);
define("DB_PORT", $_ENV['DB_PORT']);
define("DB_DATABASE", $_ENV['DB_DATABASE']);
define("DB_USERNAME", $_ENV['DB_USERNAME']);
define("DB_PASSWORD", $_ENV['DB_PASSWORD']);


// Configurações de Email
$MAIL_DRIVER = $_ENV['MAIL_DRIVER'];
$MAIL_HOST = $_ENV['MAIL_HOST'];
$MAIL_PORT = $_ENV['MAIL_PORT'];
$MAIL_USERNAME = $_ENV['MAIL_USERNAME'];
$MAIL_PASSWORD = $_ENV['MAIL_PASSWORD'];
$MAIL_ENCRYPTION = $_ENV['MAIL_ENCRYPTION'];

// Configurações do Sistema
$APP_ENV = $_ENV['APP_ENV'];

// Configurações de URL
$APP_URL = $_ENV['APP_URL_LOCAL'];

// Outras Configurações
$TIMEZONE = $_ENV['TIMEZONE'];
$LOG_CHANNEL = $_ENV['LOG_CHANNEL'];