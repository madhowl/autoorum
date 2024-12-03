<?php
declare(strict_types=1);

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

session_start();
require '../vendor/autoload.php';

$whoops = new Run;
$whoops->pushHandler(new PrettyPageHandler);
$whoops->register();

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();
require __DIR__ . '/../src/bootstrap.php';





