<?php

declare(strict_types=1);


use AutoOrum\Controller\HomeController;
use MiladRahimi\PhpRouter\Router;
use Opis\Database\Connection;
use Opis\Database\Database;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$router = Router::create();

$container = $router->getContainer();

$container->singleton(
    '$connection',
    fn() => new Connection(
        $_ENV['DB_DSN'],
        $_ENV['DB_USERNAME'],
        $_ENV['DB_PASSWORD']
    )
);
$container->singleton(
    Database::class,
    fn($connection) => new Database($connection)
);
$container->singleton(
    '$template_path',
    '../src/AutoOrum/Views'
);
$container->singleton(
    '$twig_loader',
    fn($template_path) => new FilesystemLoader($template_path)
);
$container->singleton(Environment::class,
    fn($twig_loader) => new Environment($twig_loader)
);

$router->setContainer($container);


$router->get('/', [HomeController::class, 'index']);


$router->dispatch();
/*
try {
    $router->dispatch();
} catch (RouteNotFoundException $e) {
    // It's 404!
    $router->getPublisher()->publish( new HtmlResponse( $error->render404Page(), 404));
} catch (Throwable $e) {
    // Log and report...
    $router->getPublisher()->publish( new HtmlResponse( $error->render500Page(), 500));
}*/