<?php
declare(strict_types=1);

use App\Routing\Router;

require_once __DIR__ . '/../vendor/autoload.php';

// Router
$router = new Router();
$router->handleRequest($_SERVER['REQUEST_URI']);