<?php

namespace App\Repositories\Clients;
use App\models\Clients\Client;

interface ClientsRepositoryInterface
{
    public function save(Client $client): bool;
    
    public function deleteClient(Client $client): bool;

    public function findClientId(int $id): Client;

    public function findByEmail(string $email): Client;

}