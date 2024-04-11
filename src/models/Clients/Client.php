<?php

namespace App\models\Clients;
use App\models\Account\AccountInterface;
use App\models\Clients\ClientInterface;
use App\models\Passwords\PasswordInterface;
use App\models\{CPF, Cnpj};


abstract class Client implements ClientInterface
{
    private ?int $id = null;
    private AccountInterface $account;
    private array $accounts = [];

    public function __construct(
        private readonly string $name,
        private string $type,
        private string $email,
        private PasswordInterface $password,
        private ?CPF $cpf = null,
        private ?Cnpj $cnpj = null,
        private bool $status = true,
    )
    {
        if (($cpf === null && $cnpj === null)) {
            throw new \InvalidArgumentException("É preciso informar o 'CPF' ou 'CNPJ'.");
        }

        if (($cpf !== null && $cnpj !== null)) {
            throw new \InvalidArgumentException("Só é possível informar um tipo de documento. 'CPF' ou 'CNPJ'.");
        }
    }

    public function __toString()
    {
        return $this->name;
    }


    public function getClientId(): ?int
    {
        return $this->id; 
    }

    public function setId(int $id): Void
    {
        $this->id = $id;
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getAccounts(): array
    {
        return $this->accounts;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password->getValue();
    }

    public function addAccount(AccountInterface $account): void
    {
        $this->accounts[] = $account;
    }

    public function removeAccount(AccountInterface $account): void
    {
        foreach ($this->accounts as $key => $acc) {
            if ($acc->getId() == $account->getId()) {
                unset($this->accounts[$key]);
                return;
            }
        }
    }

    public function getDocument(): string
    {
        if($this->cpf !== null) {
            return $this->cpf->getValue();
        }

        return $this->cnpj->getValue();
    }

    abstract public function canTransfer(): bool;
}