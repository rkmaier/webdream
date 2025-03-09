<?php

namespace App\Model;

class Tablet extends BaseProduct
{
    private string $screenSize;
    private int $storageCapacity;

    public function __construct(int $id, string $name, Brand $brand, int $price, string $screenSize, int $storageCapacity)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setBrand($brand);
        $this->setPrice($price);
        $this->setScreenSize($screenSize);
        $this->setStorageCapacity($storageCapacity);
    }

    public function getScreenSize(): string
    {
        return $this->screenSize ?? "1280x800";
    }

    public function setScreenSize(string $screenSize): Tablet
    {
        $this->screenSize = $screenSize;
        return $this;
    }

    public function getStorageCapacity(): int
    {
        return $this->storageCapacity ?? 0;
    }

    public function setStorageCapacity(int $storageCapacity): Tablet
    {
        $this->storageCapacity = $storageCapacity;
        return $this;
    }
}