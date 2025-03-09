<?php

namespace App\Model;
class Warehouse
{
    private int $id;
    private string $name;

    private string $address;

    private int $capacity;

    private array $stock;

    public function setStock(BaseProduct $product): Warehouse
    {
        $this->stock[$product->getId()] = $product;
        return $this;
    }

    /**
     * @param string $name
     * @param string $address
     * @param int $capacity
     */
    public function __construct(int $id, string $name, string $address, int $capacity)
    {
        $this->setAddress($address);
        $this->setCapacity($capacity);
        $this->setName($name);
        $this->setId($id);
        $this->stock = [];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Warehouse
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Warehouse
    {
        $this->name = $name;
        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): Warehouse
    {
        $this->address = $address;
        return $this;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): Warehouse
    {
        $this->capacity = $capacity;
        return $this;
    }

    public function setStocks(BaseProduct $product, &$quantity): self
    {
        $warehouses = &$_SESSION['warehouses']; // Get reference to session warehouses
        $remainingQuantity = $quantity;
        
        // Check if current warehouse has space
        $availableSpace = $this->getCapacity() - $this->getStocksCount();
        if ($availableSpace > 0) {
            $quantityToStore = min($availableSpace, $remainingQuantity);
            $this->stock[$quantityToStore] = $product;
            $remainingQuantity -= $quantityToStore;
            
            // Update current warehouse in session
            foreach ($warehouses as $key => $warehouse) {
                if ($warehouse->getId() === $this->getId()) {
                    $warehouses[$key] = $this;
                    break;
                }
            }
        }
        
        // If we still have items to store and total capacity is sufficient
        if ($remainingQuantity > 0 && $this->getTotalWarehouseCapacity() >= $this->getTotalWarehouseStocksCount() + $remainingQuantity) {
            foreach ($warehouses as $key => $warehouse) {
                if ($warehouse->getId() === $this->getId()) {
                    continue; // Skip current warehouse as we already processed it
                }
                
                $availableSpace = $warehouse->getCapacity() - $warehouse->getStocksCount();
                if ($availableSpace <= 0) {
                    continue; // Skip full warehouses
                }
                
                $quantityToStore = min($availableSpace, $remainingQuantity);
                $warehouse->stock[$quantityToStore] = $product;
                $remainingQuantity -= $quantityToStore;
                
                // Update warehouse in session
                $warehouses[$key] = $warehouse;
                
                if ($remainingQuantity <= 0) {
                    break;
                }
            }
        }
        
        // Update the reference quantity to what's left
        $quantity = $remainingQuantity;
        return $this;
    }

    private function getTotalWarehouseStocksCount(): int
    {
        $warehouses = $_SESSION['warehouses'];
        $totalCount = 0;
        foreach ($warehouses as $warehouse) {
            $totalCount += $warehouse->getStocksCount();
        }
        return $totalCount;
    }

    public function getStocks(): array
    {
        return $this->stock;
    }

    public function getStocksCount(): int
    {
        $count = 0;
        foreach ($this->stock as $key => $value) {
            $count += $key;
        }
        return $count;
    }


    public function getTotalWarehouseCapacity(): int
    {
        $warehouses = $_SESSION['warehouses'];
        $totalCapacity = 0;
        foreach ($warehouses as $warehouse) {
            $totalCapacity += $warehouse->getCapacity();
        }
        return $totalCapacity;
    }

    public function removeStocks(BaseProduct $product, &$quantity): self
    {
        $warehouses = &$_SESSION['warehouses'];
        $remainingToRemove = $quantity;

        foreach ($this->stock as $stockQuantity => $stockProduct) {
            if ($stockProduct->getId() === $product->getId()) {
                if ($stockQuantity >= $remainingToRemove) {
                    if ($stockQuantity === $remainingToRemove) {
                        unset($this->stock[$stockQuantity]);
                    } else {
                        unset($this->stock[$stockQuantity]);
                        $this->stock[$stockQuantity - $remainingToRemove] = $product;
                    }
                    $remainingToRemove = 0;

                    foreach ($warehouses as $key => $warehouse) {
                        if ($warehouse->getId() === $this->getId()) {
                            $warehouses[$key] = $this;
                            break;
                        }
                    }
                    break;
                } else {
                    unset($this->stock[$stockQuantity]);
                    $remainingToRemove -= $stockQuantity;

                    foreach ($warehouses as $key => $warehouse) {
                        if ($warehouse->getId() === $this->getId()) {
                            $warehouses[$key] = $this;
                            break;
                        }
                    }
                }
            }
        }

        if ($remainingToRemove > 0) {
            foreach ($warehouses as $key => $warehouse) {
                if ($warehouse->getId() === $this->getId()) {
                    continue;
                }

                foreach ($warehouse->getStocks() as $stockQuantity => $stockProduct) {
                    if ($stockProduct->getId() === $product->getId()) {
                        if ($stockQuantity >= $remainingToRemove) {
                            if ($stockQuantity === $remainingToRemove) {
                                unset($warehouse->stock[$stockQuantity]);
                            } else {
                                unset($warehouse->stock[$stockQuantity]);
                                $warehouse->stock[$stockQuantity - $remainingToRemove] = $product;
                            }
                            $remainingToRemove = 0;


                            $warehouses[$key] = $warehouse;
                            break 2;
                        } else {
                            unset($warehouse->stock[$stockQuantity]);
                            $remainingToRemove -= $stockQuantity;


                            $warehouses[$key] = $warehouse;
                        }
                    }
                }
            }
        }

        $quantity = $remainingToRemove;
        return $this;
    }
}