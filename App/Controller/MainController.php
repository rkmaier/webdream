<?php

namespace App\Controller;

use App\Model\Book;
use App\Model\Brand;
use App\Model\Tablet;
use App\Model\TV;
use App\Model\Warehouse;

class MainController
{
    protected \eftec\bladeone\BladeOne $blade;

    public function __construct()
    {
        $this->blade = new \eftec\bladeone\BladeOne(
            __DIR__ . '/../../views',
            __DIR__ . '/../../compiles',
            \eftec\bladeone\BladeOne::MODE_DEBUG
        );

        // Initialize session data if not exists
        $this->initializeSession();
    }

    protected function render(string $view, array $params = []): void
    {
        echo $this->blade->run($view, $params);
    }

    protected function initializeSession(): void
    {
        if (!isset($_SESSION['warehouses'])) {
            $_SESSION['warehouses'] = [
                new Warehouse(1, 'Warehouse 1', 'Address 1', 100),
                new Warehouse(2, 'Warehouse 2', 'Address 2', 100),
                new Warehouse(3, 'Warehouse 3', 'Address 3', 100),
            ];
        }

        if (!isset($_SESSION['brands'])) {
            $_SESSION['brands'] = [
                new Brand(1, 'Brand 1', 5),
                new Brand(2, 'Brand 2', 2),
            ];
        }

        if (!isset($_SESSION['products'])) {
            $brand1 = $_SESSION['brands'][0];
            $brand2 = $_SESSION['brands'][1];

            $_SESSION['products'] = [
                new Tablet(1, "Tablet", $brand1, 10, "1280x720", 500),
                new Book(2, "Book", $brand1, 10, "Author", "1234567890", 100, "Genre"),
                new TV(3, 'TV 1', $brand2, 300, 'green', 100, '4k'),
            ];
        }
    }
}
