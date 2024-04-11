<?php

namespace App\Infra\Persistencia;
use PDO;
use PDOException;

require_once __DIR__ . "/../../../config/config.php";

final class ConnectionFactory
{
    public static function CreateConnection(): PDO {
        try{
            $connection = DB_CONNECTION;
            $host = DB_HOST;
            $name = DB_DATABASE;
            $userName = DB_USERNAME;
            $password = DB_PASSWORD;
            $port = DB_PORT;

            $pdo = new PDO("$connection:host=$host;dbname=$name", $userName, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch (PDOException $e) {
            echo "ERROR => " . $e->getMessage() . PHP_EOL;
            exit();
        }

        return $pdo;
    }
}