<?php

namespace App\Controllers\Api\v1;
use App\models\Account\PaymentAccount;
use App\models\Clients\MerchantClient;
use App\models\Cnpj;
use App\models\Exceptions\InvalidCNPJException;
use App\models\Exceptions\InvalidPasswordException;
use App\models\Passwords\Argon2idPasswordManager;
use App\Repositories\Clients\ClientRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CadastroClientController implements RequestHandlerInterface
{
    public function __construct(private ClientRepository $clientRepository)
    {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $params = json_decode($request->getBody()->getContents(), true);

        $name = filter_var($params['name']);
        $email = filter_var($params['email'], FILTER_VALIDATE_EMAIL);
        $password = filter_var($params['password']);
        $cpf = isset($params['cpf']) ? filter_var($params['cpf']) : null;
        $cnpj = isset($params['cnpj']) ? filter_var($params['cnpj']) : null;
        $type = strtolower(filter_var($params['type']));

        // validações da requisição
        if(!$name || $name == "") {
            return new Response(401, ["Content-type" => "application/json"], json_encode([
                "message" => "É preciso informar um nome para cadastrar um usuário.",
                "status" => 401
            ], true));
        }
        
        if(strlen($name) < 3) {
            return new Response(401, ["Content-type" => "application/json"], json_encode([
                "message" => "É preciso informar um nome com 3 ou mais letras para criar um novo usuário.",
                "status" => 401
            ], true));    
        }
        
        if(!$email || $email == "") {
            return new Response(401, ["Content-type" => "application/json"], json_encode([
                "message" => "É preciso informar um Email válido para criar um novo usuário.",
                "status" => 401
            ], true));    
        }
        
        if(!$password || $password == "") {
            return new Response(401, ["Content-type" => "application/json"], json_encode([
                "message" => "É preciso informar uma senha criar um novo usuário.",
                "status" => 401
            ], true));    
        }

        if(!$type || $type == "") {
            return new Response(401, ["Content-type" => "application/json"], json_encode([
                "message" => "É preciso informar um tipo válido para criar um novo usuário.",
                "status" => 401
            ], true));    
        }
        
        if($type !== "m" && $type !== "r") {
            return new Response(401, ["Content-type" => "application/json"], json_encode([
                "message" => "É preciso informar 'M' para Lojista ou 'R' para comum, para criar um novo usuário.",
                "status" => 401
            ], true));    
        }
        
        if($type === "m" && $cnpj === null) {
            return new Response(401, ["Content-type" => "application/json"], json_encode([
                "message" => "É preciso informar um CNPJ para lojistas.",
                "status" => 401
            ], true));    
        }
        
        if($type === "r" && $cpf === null) {
            return new Response(401, ["Content-type" => "application/json"], json_encode([
                "message" => "É preciso informar um CPF para pessoas físicas.",
                "status" => 401
            ], true));    
        }
        
        if($cpf === null && $cnpj === null) {
            return new Response(401, ["Content-type" => "application/json"], json_encode([
                "message" => "É preciso informar um CPF ou CNPJ para continuar.",
                "status" => 401
            ], true));        
        }

        try{
            $pass = new Argon2idPasswordManager($password);
        } catch(InvalidPasswordException $e) {
            return new Response(401, ["Content-type" => "application/json"], json_encode([
                "message" => $e->getMessage(),
                "status" => $e->getCode()
            ], true));
        }

        if($type === "m") {
            try{
                $cnpj = new Cnpj($cnpj);
            } catch (InvalidCNPJException $e) {
                return new Response(401, ["Content-type" => "application/json"], json_encode([
                    "message" => $e->getMessage(),
                    "status" => $e->getCode()
                ], true));
            }

            $client = new MerchantClient($name, $email, $pass, $cnpj);

            try {
                $this->clientRepository->save($client);
            } catch (\PDOException $e) {
                return new Response(401, ["Content-type" => "application/json"], json_encode([
                    "message" => $e->getMessage(),
                    "status" => $e->getCode()
                ], true));
            }

            $account = new PaymentAccount($client);
        }        


        if($type === "m") {
            $client = new MerchantClient(
                $name, $email, $pass, 
            );
        }

        
        
        return new Response(200, ["Content-type" => "application/json"], json_encode([
            "message" => "sucesso",
            "status" => 200,
            "senha" => $pass->getValue()
        ], true));
        

    }
}