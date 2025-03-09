<?php

namespace Tests;

use App\Model\Book;
use App\Model\Brand;
use App\Model\Tablet;
use App\Model\TV;
use App\Model\Warehouse;
use PHPUnit\Framework\TestCase;

class WarehouseTest extends TestCase
{
    private Warehouse $warehouse;
    private Brand $brand;
    private Tablet $tablet;
    private Book $book;
    private TV $tv;

    protected function setUp(): void
    {
        $_SESSION = [];
        $this->warehouse = new Warehouse(1, 'Test Warehouse', 'Test Address', 100);
        $this->brand = new Brand(1, 'Test Brand', 5);

        $this->tablet = new Tablet(
            1,
            "Test Tablet",
            $this->brand,
            499,
            "10.9 inch",
            256
        );

        $this->book = new Book(
            2,
            "Test Book",
            $this->brand,
            29,
            "Test Author",
            "123-456-789",
            300,
            "Fiction"
        );

        $this->tv = new TV(
            3,
            "Test TV",
            $this->brand,
            999,
            "Black",
            55,
            "4K"
        );

        $_SESSION['warehouses'] = [$this->warehouse];
    }

    public function testWarehouseCreation(): void
    {
        $warehouse = new Warehouse(1, 'New Warehouse', 'Test Address 123', 200);

        $this->assertEquals(1, $warehouse->getId());
        $this->assertEquals('New Warehouse', $warehouse->getName());
        $this->assertEquals('Test Address 123', $warehouse->getAddress());
        $this->assertEquals(200, $warehouse->getCapacity());
        $this->assertEmpty($warehouse->getStocks());
    }

    public function testWarehouseCreationWithZeroCapacity(): void
    {
        $warehouse = new Warehouse(1, 'Zero Capacity', 'Address', 0);
        $this->assertEquals(0, $warehouse->getCapacity());
        $this->assertEmpty($warehouse->getStocks());

        $quantity = 10;
        $warehouse->setStocks($this->tablet, $quantity);
        $this->assertEquals(10, $quantity); // Should remain unchanged
        $this->assertEquals(0, $warehouse->getStocksCount());
    }

    public function testWarehouseCreationWithMultipleWarehouses(): void
    {
        $warehouse1 = new Warehouse(1, 'Warehouse 1', 'Address 1', 100);
        $warehouse2 = new Warehouse(2, 'Warehouse 2', 'Address 2', 150);
        $warehouse3 = new Warehouse(3, 'Warehouse 3', 'Address 3', 200);

        $_SESSION['warehouses'] = [$warehouse1, $warehouse2, $warehouse3];

        $this->assertEquals(450, $warehouse1->getTotalWarehouseCapacity());
        $this->assertCount(3, $_SESSION['warehouses']);

        $this->assertEquals('Warehouse 1', $warehouse1->getName());
        $this->assertEquals('Warehouse 2', $warehouse2->getName());
        $this->assertEquals('Warehouse 3', $warehouse3->getName());

        $this->assertEquals(100, $warehouse1->getCapacity());
        $this->assertEquals(150, $warehouse2->getCapacity());
        $this->assertEquals(200, $warehouse3->getCapacity());
    }

    public function testWarehousePropertyModification(): void
    {
        $warehouse = new Warehouse(1, 'Initial Name', 'Initial Address', 100);

        $warehouse->setName('Updated Name')
            ->setAddress('Updated Address')
            ->setCapacity(150);

        $this->assertEquals('Updated Name', $warehouse->getName());
        $this->assertEquals('Updated Address', $warehouse->getAddress());
        $this->assertEquals(150, $warehouse->getCapacity());
    }

    public function testWarehouseInitialState(): void
    {
        $warehouse = new Warehouse(1, 'Test Warehouse', 'Test Address', 100);

        $this->assertEquals(0, $warehouse->getStocksCount());
        $this->assertEmpty($warehouse->getStocks());
        $this->assertEquals(100, $warehouse->getCapacity());

        $quantity = 50;
        $warehouse->setStocks($this->tablet, $quantity);
        $this->assertEquals(50, $warehouse->getStocksCount());
    }

    public function testAddMultipleStocksToWarehouse(): void
    {
        $tabletQuantity = 20;
        $this->warehouse->setStocks($this->tablet, $tabletQuantity);

        $bookQuantity = 30;
        $this->warehouse->setStocks($this->book, $bookQuantity);

        $tvQuantity = 10;
        $this->warehouse->setStocks($this->tv, $tvQuantity);

        $stocks = $this->warehouse->getStocks();

        $this->assertCount(3, $stocks);
        $this->assertEquals($this->tablet, $stocks[20]);
        $this->assertEquals($this->book, $stocks[30]);
        $this->assertEquals($this->tv, $stocks[10]);
    }

    public function testWarehouseCapacityLimit(): void
    {
        $quantity = 150;
        $this->warehouse->setStocks($this->tablet, $quantity);

        $this->assertEquals(100, $this->warehouse->getStocksCount());
        $this->assertEquals(50, $quantity);
    }

    public function testDistributeStockAcrossWarehouses(): void
    {
        $warehouse2 = new Warehouse(2, 'Warehouse 2', 'Address 2', 100);
        $warehouse3 = new Warehouse(3, 'Warehouse 3', 'Address 3', 100);
        $_SESSION['warehouses'] = [$this->warehouse, $warehouse2, $warehouse3];

        $quantity = 250;
        $this->warehouse->setStocks($this->tablet, $quantity);

        $this->assertEquals(100, $this->warehouse->getStocksCount());
        $this->assertEquals(100, $warehouse2->getStocksCount());
        $this->assertEquals(50, $warehouse3->getStocksCount());
        $this->assertEquals(0, $quantity); // All stock should be distributed
    }

    public function testGetSpecificProductDetails(): void
    {
        $tabletQuantity = 20;
        $this->warehouse->setStocks($this->tablet, $tabletQuantity);

        $stocks = $this->warehouse->getStocks();
        $this->assertEquals(key($stocks), 20);

        $this->assertEquals("10.9 inch", $this->tablet->getScreenSize());
        $this->assertEquals(256, $this->tablet->getStorageCapacity());

        $this->assertEquals("Test Tablet", $this->tablet->getName());
        $this->assertEquals(499, $this->tablet->getPrice());
        $this->assertEquals("Test Brand", $this->tablet->getBrand()->getName());
    }

    public function testRemoveStockFromWarehouse(): void
    {
        $initialQuantity = 50;
        $this->warehouse->setStocks($this->tablet, $initialQuantity);

        $removeQuantity = 20;
        $this->warehouse->removeStocks($this->tablet, $removeQuantity);

        $this->assertEquals(30, $this->warehouse->getStocksCount());
    }

    public function testAddDifferentProductTypes(): void
    {
        $quantities = [
            'tablet' => 10,
            'book' => 15,
            'tv' => 20
        ];
        $originalQuantities = $quantities;

        $this->warehouse->setStocks($this->tablet, $quantities['tablet']);
        $this->warehouse->setStocks($this->book, $quantities['book']);
        $this->warehouse->setStocks($this->tv, $quantities['tv']);

        $stocks = $this->warehouse->getStocks();

        foreach ($stocks as $quantity => $product) {
            if ($product instanceof Tablet) {
                $this->assertEquals($originalQuantities['tablet'], $quantity);
                $this->assertEquals("10.9 inch", $product->getScreenSize());
            } elseif ($product instanceof Book) {
                $this->assertEquals($originalQuantities['book'], $quantity);
                $this->assertEquals("Test Author", $product->getAuthor());
            } elseif ($product instanceof TV) {
                $this->assertEquals($originalQuantities['tv'], $quantity);
                $this->assertEquals("4K", $product->getResolution());
            }
        }

        $this->assertEquals(
            array_sum($originalQuantities),
            $this->warehouse->getStocksCount()
        );
    }
} 