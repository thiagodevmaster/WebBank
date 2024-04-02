<?php

namespace App\models\Passwords;
use App\models\Clients\Client;
use App\models\Exceptions\InvalidPasswordException;
use Throwable;

class Argon2idPasswordManager implements PasswordInterface
{
    private string $password;
    protected string $salt;

    public function __construct(string $password)
    {
        try {
            $this->validatePassword($password);
            $this->salt = $this->generateSalt();
            $this->password = $this->hash($password);
        } catch (InvalidPasswordException $e) {
            throw $e;
        }
    }

    protected function validatePassword(string $password): bool
    {
        if(strlen($password) < 8) {
            throw new InvalidPasswordException("Senha menor que 8 dígitos");
        }

        // Verifica se a senha contém pelo menos uma letra maiúscula
        if (!preg_match('/[A-Z]/', $password)) {
            throw new InvalidPasswordException("A senha deve conter pelo menos uma letra maiúscula");
        }

        // Verifica se a senha contém pelo menos uma letra minúscula
        if (!preg_match('/[a-z]/', $password)) {
            throw new InvalidPasswordException("A senha deve conter pelo menos uma letra minúscula");
        }

        // Verifica se a senha contém pelo menos um caractere especial
        if (!preg_match('/[^a-zA-Z0-9]/', $password)) {
            throw new InvalidPasswordException("A senha deve conter pelo menos um caractere especial");
        }

        // Verifica se a senha contém números sequenciais (ex: 123, 456)
        if (preg_match('/\d{3}/', $password)) {
            throw new InvalidPasswordException("A senha não pode conter números sequenciais");
        }

        // Verifica se a senha contém números repetidos (ex: 111, 222)
        if (preg_match('/(\d)\1{2}/', $password)) {
            throw new InvalidPasswordException("A senha não pode conter números repetidos");
        }

        return true;
        
    }

    public function hash(string $password): string 
    {
        $options = ['salt' => $this->salt];
        $hash = password_hash($password, PASSWORD_ARGON2ID, $options);
        return $hash;
    }

    public function verify(string $password, string $hashadPassword): bool 
    {
        if(!password_verify($password, $hashadPassword)){
            return false;
        }

        return true;
    }

    public function resetPassword(Client $client, string $newPassword): bool 
    {

    }

    public function generateSalt(): string 
    {
        $bytes = base64_encode(random_bytes(7));
        return $bytes;
    }

    
}