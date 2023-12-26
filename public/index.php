<?php

declare(strict_types=1);

// use Dotenv\Dotenv;
use App\Router\Router;

session_start();

require_once '../vendor/autoload.php';

setlocale(LC_CTYPE, 'fr_FR', 'fra');

// $dotenv = Dotenv::createImmutable('..\\')->load();

$router = new Router();
$router->run();
