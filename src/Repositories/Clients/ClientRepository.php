<?php

namespace App\Repositories\Clients;
use App\models\Clients\Client;
use App\models\Clients\MerchantClient;
use App\models\Cnpj;
use App\models\Passwords\Argon2idPasswordManager;
use Exception;
use PDO;
use PDOStatement;

class ClientRepository implements ClientsRepositoryInterface
{
    protected string $tableName = "tb_clients";
    public function __construct(private PDO $pdo)
    {}

    public function createClient(Client $client): bool 
    {
        $sql = "INSERT INTO $this->tableName (cli_name, cli_cpf_cnpj, cli_email, cli_password, cli_type) VALUES (:name, :cpf_cnpj, :email, :password, :type);";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":name", $client->getName(), PDO::PARAM_STR);
        $stmt->bindValue(":cpf_cnpj", $client->getDocument(), PDO::PARAM_STR);
        $stmt->bindValue(":email", $client->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(":password", $client->getPassword(), PDO::PARAM_STR);
        $stmt->bindValue(":type", $client->getType(), PDO::PARAM_STR);

        return $stmt->execute(); 
    }

    public function updateClient(Client $client): bool 
    {
        $sql = "UPDATE $this->tableName SET (cli_name = :name, cli_cpf_cnpj = :cpf_cnpj, cli_email = :email, cli_password = :password, cli_type = :type) WHERE cli_id = :id;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":name", $client->getName(), PDO::PARAM_STR);
        $stmt->bindValue(":cpf_cnpj", $client->getDocument(), PDO::PARAM_STR);
        $stmt->bindValue(":email", $client->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(":password", $client->getPassword(), PDO::PARAM_STR);
        $stmt->bindValue(":type", $client->getType(), PDO::PARAM_STR);
        $stmt->bindValue(":id", $client->getClientId(), PDO::PARAM_INT);

        return $stmt->execute(); 
    }
    
    public function deleteClient(Client $client): bool 
    {
        $sql = "DELETE * FROM $this->tableName WHERE cli_id = :id;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $client->getClientId(), PDO::PARAM_INT);
        
        return $stmt->execute(); 
    }
    
    
    public function findClientId(int $id): Client 
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->tableName} WHERE cli_id = :id;");
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        
        if(!$stmt->execute()){
            throw new Exception("Não encontrado cliente com este id");
        };

        $ClientData = self::hydrateClient($stmt);

        if(empty($ClientData)){
            throw new Exception("Não foi possivel tratar os dados deste usuário");
        }

        return $ClientData[0];
    }

    protected function save(Client $client): bool 
    {
        if($client->getClientId() !== null){
            return $this->updateClient($client);
        }
        
        return $this->createClient($client);
    }

    protected function hydrateClient(PDOStatement $stmt): array 
    {
        $clientDataList = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $clientList = [];

        foreach($clientDataList as $key => $value) {
            if($value['cli_type'] === "m") {
                $client = new MerchantClient(
                    $value['cli_name'], 
                    $value['cli_email'],
                    new Argon2idPasswordManager($value['cli_password']),
                    new Cnpj($value['cli_cpf_cnpj']),
                    $value['cli_status']
                );

                $client->setId($value['cli_id']);

                $clientList[] = $client;
            }
        }

        return $clientList;
    }

    public function findByEmail(string $email): Client 
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->tableName} WHERE cli_email = :email;");
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        
        if(!$stmt->execute()){
            throw new Exception("Não encontrado cliente com este id");
        };

        $ClientData = self::hydrateClient($stmt);

        if(empty($ClientData)){
            throw new Exception("Não foi possivel tratar os dados deste usuário");
        }

        return $ClientData[0];
    }
}