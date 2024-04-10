<?php

require_once __DIR__ . "/../../vendor/autoload.php";

use App\models\Cnpj;
use App\models\Passwords\Argon2idPasswordManager;
use App\Repositories\Clients\ClientRepository;
use App\models\Clients\MerchantClient;


it('creates a client', function () {
    // Mock PDO e PDOStatement
    $pdoMock = Mockery::mock(PDO::class);
    $pdoStatementMock = Mockery::mock(PDOStatement::class);
    $pdoMock->shouldReceive('prepare')
        ->andReturn($pdoStatementMock);

    // Defina as expectativas para o mock PDOStatement
    $pdoStatementMock->shouldReceive('bindValue')->times(5)->andReturn(true);
    $pdoStatementMock->shouldReceive('execute')->andReturn(true);

    // Crie uma instância de MerchantClient
    $client = new MerchantClient(
        "Thiago",
        "thiago@email.com",
        new Argon2idPasswordManager("Password196!"),
        new Cnpj("65137189000104"),
        true
    );

    // Crie uma instância de ClientRepository com o mock PDO
    $clientRepository = new ClientRepository($pdoMock);

    // Asserte que a criação do cliente é bem-sucedida
    expect($clientRepository->createClient($client))->toBeTrue();
    
    $pdoMock->shouldReceive('query')
        ->with("SELECT * FROM tb_clients WHERE cli_email = 'thiago@email.com'")
        ->andReturn($pdoStatementMock);

    $pdoStatementMock->shouldReceive('fetch')
        ->andReturn([
            'cli_name' => 'Thiago',
            'cli_email' => 'thiago@email.com',
            'cli_password' => $client->getPassword(),
        ]);

    $result = $pdoMock->query("SELECT * FROM tb_clients WHERE cli_email = 'thiago@email.com'")->fetch(PDO::FETCH_ASSOC);

    // Assertions
    expect($result)->toBeArray();
    expect($result['cli_name'])->toBe('Thiago');
    expect($result['cli_email'])->toBe('thiago@email.com');
    expect($result['cli_password'])->toBe($client->getPassword());
});


