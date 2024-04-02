<?php
use App\Controllers\Api\v1\LoginController;

$public = [
    "GET|/api/login" => LoginController::class
];

$routes =  [
    "public" => $public,
];

return $routes;