<?php

namespace App\models\Passwords;
use App\models\Clients\Client;
use App\models\Exceptions\InvalidPasswordException;
use Throwable;

class Argon2idPasswordManager implements PasswordInterface
{
    private string $password;

    public function __construct(string $password)
    {
        if ($this->isHashedPassword($password)) {
            // Se a senha recebida já for um hash, armazene-a diretamente
            $this->password = $password;
        } else {
            // Caso contrário, proceda normalmente com a validação, geração de salt e hash
            try {
                $this->validatePassword($password);
                $this->password = $this->hash($password);
            } catch (InvalidPasswordException $e) {
                throw $e;
            }
        }
    }

    public function getValue(): string 
    {
        return $this->password;
    }

    public function validatePassword(string $password): bool
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
        if (preg_match('/123|234|345|456|567|678|789/', $password)) {
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
        $hash = password_hash($password, PASSWORD_ARGON2ID);
        return $hash;
    }

    public function verify(string $password, string $hashedPassword): bool 
    {
        $rehashedPassword = password_hash($password, PASSWORD_ARGON2ID);

        if(!password_verify($password, $rehashedPassword)){
            return false;
        }

        return true;
    }

    protected function isHashedPassword(string $password): bool
    {
        return strpos($password, '$argon2id$') === 0;
    }

    public function resetPassword(Client $client, string $newPassword): bool 
    {
        // TODO
        return true;
    }


    
}