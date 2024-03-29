<?php

use App\Infra\Persistencia\ConnectionFactory;
use DI\ContainerBuilder;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$builder = new ContainerBuilder();

$builder->addDefinitions([
    Environment::class => function(): Environment{
        $loader = new FilesystemLoader(__DIR__ . "/../views");
        $twig = new Environment($loader);
        return $twig;
    },
    PDO::class => function(): PDO {
        $connection = ConnectionFactory::CreateConnection();
        return $connection;
    }
]);

$container = $builder->build();

return $container;