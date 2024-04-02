<?php

namespace App\Controllers\Api\v1;
use Nyholm\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginController implements RequestHandlerInterface
{

    public function __construct()
    {}
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $formData = json_encode(["teste" => "Deu certo"]);

        return new Response(200, ["Content-Type" => "application/json"], $formData);
    }
}