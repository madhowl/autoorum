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
    fn() => new Database($container->get('$connection'))
);
$container->singleton(
    '$template_path',
    '../src/AutoOrum/Views'
);
$container->singleton(
    '$twig_loader',
    fn() => new FilesystemLoader($container->get('$template_path'))
);
$container->singleton(Environment::class,
    fn() => new Environment($container->get('$twig_loader'))
);

$router->setContainer($container);


$router->get('/', [HomeController::class, 'index']);
$router->get('/api/get_companies', [HomeController::class, 'get_companies']);
$router->get('/api/get_models/{company_id}', [HomeController::class, 'get_models']);
$router->get('/api/get_years/{model_id}', [HomeController::class, 'get_years']);
$router->get('/api/get_configurations/{car_id}', [HomeController::class, 'get_configurations']);


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