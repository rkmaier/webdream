<?php
namespace App\Controller;

use App\Model\Warehouse;

class WarehouseController extends MainController
{
    public function create()
    {
         echo $this->blade->setView('create')
        ->run();
    }

    public function list()
    {
        $warehouses = $_SESSION['warehouses'] ?? [];
        $data = $_GET;
        $showError = false;
        $msg = "";

        if (isset($data['show']) && $data['show'] == 'error') {
            $msg = $data['msg'];
            $showError = true;
        }
        echo $this->blade
            ->share(compact('warehouses', 'showError', 'msg'))
            ->setView('list')
            ->run();
    }

    public function save()
    {
        $data = $_POST;
        $warehouses =  isset($_SESSION['warehouses']) ? $_SESSION['warehouses'] : [];
        $warehouse = new Warehouse(count($warehouses)+1, $data['name'], $data['address'], $data['capacity']);
        $_SESSION['warehouses'][] = $warehouse;
        header('Location: /');
        exit();
    }

    public function addStock()
    {
        echo $this->blade
            ->setView('list')
            ->run();
    }


    public function view()
    {
        $id = $_GET['id'];
        $warehouse = null;

        foreach ($_SESSION['warehouses'] as $w) {
            if ($w->getId() == $id) {
                $warehouse = $w;
                break;
            }
        }
        echo $this->blade
            ->share(compact('warehouse'))
            ->setView('view')
            ->run();
    }
}