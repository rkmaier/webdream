<?php

namespace App\Controller;

use App\Model\Brand;
use App\Model\Mobile;
use App\Model\Tablet;
use App\Model\TV;
use App\Model\Warehouse;
use eftec\bladeone\BladeOne;

class MainController
{
    protected BladeOne $blade;
    public function __construct()
   {
       $this->blade = new BladeOne();
       session_start();
   }

}
