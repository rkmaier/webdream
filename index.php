<?php

require_once './vendor/autoload.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use App\Controller\StockController;
use App\Controller\WarehouseController;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;

$dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $r) {
    $r->addRoute('GET', '/', [WarehouseController::class, 'list']);
    $r->addRoute('GET', '/create', [WarehouseController::class, 'create']);
    $r->addRoute('POST', '/save', [WarehouseController::class, 'save']);
    $r->addRoute('GET', '/addStock', [StockController::class, 'addStock']);
    $r->addRoute('GET', '/removeStock', [StockController::class, 'removeStock']);
    $r->addRoute('POST', '/saveStock', [StockController::class, 'saveStock']);
    $r->addRoute('GET', '/view', [WarehouseController::class, 'view']);
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}

$uri = rawurldecode($uri);
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case Dispatcher::NOT_FOUND:
        header("HTTP/1.0 404 Not Found");
        echo '404 Not Found';
        break;
    case Dispatcher::METHOD_NOT_ALLOWED:
        header("HTTP/1.0 405 Method Not Allowed");
        echo '405 Method Not Allowed';
        break;
    case Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        [$controller, $method] = $handler;
        $controller = new $controller();
        call_user_func([$controller, $method], $vars);
        break;
}