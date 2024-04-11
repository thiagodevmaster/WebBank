<?php
use App\Controllers\Api\v1\CadastroClientController;
use App\Controllers\Api\v1\LoginController;

$public = [
    "GET|/api/v1/login" => LoginController::class,
    "POST|/api/v1/cadastro" => CadastroClientController::class,
];

$routes =  [
    "public" => $public,
];

return $routes;