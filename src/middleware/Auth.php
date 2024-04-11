<?php

namespace App\middleware;
use App\Repositories\Clients\ClientRepository;
use Firebase\JWT\JWT;

class Auth
{
    private string $secretKey = "PIC-pay-secret";

    public function __construct(private ClientRepository $clientRepository)
    {}

    public function validateToken(string $token): bool
    {
        try{
            $decoded = JWT::decode($token, $this->secretKey, array('HS256'));
            return true;
        } catch (\Exception $e){
            return false;
        }
    }

    public function generateToken(string $cpf, string $senha): string
    {
        
    }
}