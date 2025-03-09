<?php

namespace App\Controller;

class StockController extends MainController
{

    public function addStock()
    {
            $warehouses = $_SESSION['warehouses'] ?? [];
            $products = $_SESSION['products'] ?? [];

        echo $this->blade
            ->share(compact('warehouses', 'products'))
            ->setView('addStock')
            ->run();
    }


    public function removeStock()
    {
        $warehouses = $_SESSION['warehouses'] ?? [];
        $products = $_SESSION['products'] ?? [];

        echo $this->blade
            ->share(compact('warehouses', 'products'))
            ->setView('removeStock')
            ->run();
    }


    public function saveStock()
    {
        $data = $_POST;
        $warehouses = ($_SESSION['warehouses']);

        $selectedWarehouse = collect($warehouses)->filter(function ($value, int $key) use ($data) {
            return $value->getId() == $data['warehouse'];
        })->first();

        $selectedProduct = collect($_SESSION['products'])->filter(function ($value, int $key) use ($data) {
            return $value->getId() == $data['product'];
        })->first();

        if ($data['type'] == 'remove') {
            $selectedWarehouse->removeStocks($selectedProduct, $data['stock']);
        } else {
            $res = $selectedWarehouse->setStocks($selectedProduct, $data['stock']);
        }

        if (is_array($res)) {
            $msg = $res[1];
            $type = 'error';
        }

        header("Location: /?show={$type}&msg={$msg}");
        exit();
    }
}