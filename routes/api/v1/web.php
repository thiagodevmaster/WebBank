<?php
use App\Controllers\Api\v1\LoginController;

$public = [
    "GET|/api/v1/login" => LoginController::class
];

$routes =  [
    "public" => $public,
];

return $routes;