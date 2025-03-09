<?php


require_once './vendor/autoload.php';

use App\Controller\StockController;
use App\Controller\WarehouseController;
use App\Model\Book;
use App\Model\Tablet;
use App\Model\Brand;
use App\Model\TV;
use App\Model\Warehouse;
use FastRoute\RouteCollector;
use FastRoute\Dispatcher;


$dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $r) {
    $r->addRoute('GET', '/', [WarehouseController::class, 'list']);
    $r->addRoute('GET', '/create', [WarehouseController::class, 'create']);
    $r->addRoute('POST', '/save', [WarehouseController::class, 'save']);
    $r->addRoute('GET', '/addStock', [StockController::class, 'addStock']);
    $r->addRoute('GET', '/removeStock', [StockController::class, 'removeStock']);
    $r->addRoute('POST', '/saveStock', [StockController::class, 'saveStock']);
    $r->addRoute('GET', '/view', [WarehouseController::class, 'view']);
});


$_SESSION['warehouses'] = [
    new Warehouse(1,'Warehouse 1', 'Address 1', 100),
    new Warehouse(2,'Warehouse 2', 'Address 3', 100),
    new Warehouse(3, 'Warehouse 3', 'Address 3', 100),
];


$_SESSION['brands'] = [
    new Brand(1,'Brand', 5),
    new Brand(2, 'Brand', 2),
];

$brand = $_SESSION['brands'][0];
$brand2 = $_SESSION['brands'][1];

$_SESSION['products'] = [
    new Tablet(1, "Tablet", $brand, 10, "1280x720", 500),
    new Book(2, "Book", $brand, 10, "Author", "1234567890", 100, "Genre"),
    new TV( 3, 'TV 1', $brand2, 300, 'green', 100, '4k'),
];





$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}

$uri = rawurldecode($uri);
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        header("HTTP/1.0 404 Not Found");
        echo '404 Not Found';
        break;
    case Dispatcher::METHOD_NOT_ALLOWED:
        // ... 405 Method Not Allowed
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