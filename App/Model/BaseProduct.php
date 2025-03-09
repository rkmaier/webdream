<?php

namespace App\Model;
abstract class BaseProduct
{
    private int $id;
    private string $name;
    private int $price;
    private Brand $brand;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): BaseProduct
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): BaseProduct
    {
        $this->name = $name;
        return $this;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): BaseProduct
    {
        $this->price = $price;
        return $this;
    }

    public function getBrand(): Brand
    {
        return $this->brand;
    }

    public function setBrand(Brand $brand): BaseProduct
    {
        $this->brand = $brand;
        return $this;
    }

}