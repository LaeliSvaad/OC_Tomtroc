<?php
declare(strict_types=1);

use App\Routing\Router;

require_once __DIR__ . '/../vendor/autoload.php';

// Démarrer la session
session_start();
$_SESSION['user'] = 1; // Exemple temporaire
// Router
$router = new Router();
$router->handleRequest($_SERVER['REQUEST_URI']);