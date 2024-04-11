<?php
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;

session_start();
session_regenerate_id();
require_once __DIR__ . "/../vendor/autoload.php";

$pathInfo = $_SERVER['REQUEST_URI'] ?? "/";
$httpMethod = $_SERVER['REQUEST_METHOD'];

$key = "$httpMethod|$pathInfo";


$routes = require_once __DIR__ . "/../routes/api/v1/web.php";
$dependencyContainer = require_once __DIR__ . "/../config/dependency.php";

function findRoute($routes, $path) {
  foreach ($routes as $groupRoutes) { 
      foreach ($groupRoutes as $route => $action) {
          if($path === $route) {
              return $action;
          }
      }
    //   exit;
  }
  return null;
}

$action = findRoute($routes, $key);



if($action !== null){
    $controller = $dependencyContainer->get($action);
}else{
    http_response_code(404);
}

$psr17Factory = new Psr17Factory();

$creator = new ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);

$request = $creator->fromGlobals();

/**
 * @var RequestHandleInteface $controller
 **/
$response = $controller->handle($request);

http_response_code($response->getStatusCode());
// Emit headers iteratively:
     foreach ($response->getHeaders() as $name => $values) {
             foreach ($values as $value) {
                 header(sprintf('%s: %s', $name, $value), false);
             }
         }

echo $response->getBody();