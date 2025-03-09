<?php

namespace App\Model;
class Brand
{
    private string $name;
    private int $quality;

    private int $id;

    public function __construct($id, string $name, int $quality)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setQuality($quality);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Brand
    {
        $this->name = $name;
        return $this;
    }

    public function getQuality(): int
    {
        return $this->quality;
    }

    public function setQuality(int $quality): Brand
    {
        $this->quality = $quality;
        return $this;
    }

    private function setId($id)
    {
        $this->id = $id;
        return $this;
    }


}