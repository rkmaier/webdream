<?php

namespace App\Model;
class TV extends BaseProduct
{
    private string $model;
    private string $color;
    private string $screenSize;
    private string $resolution;

    public function __construct(int $id, $name, Brand $brand, string $model, string $color, string $screenSize, string $resolution)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setBrand($brand);
        $this->setModel($model);
        $this->setColor($color);
        $this->setScreenSize($screenSize);
        $this->setResolution($resolution);
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param mixed $model
     * @return TV
     */
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     * @return TV
     */
    public function setColor($color)
    {
        $this->color = $color;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getScreenSize()
    {
        return $this->screenSize;
    }

    /**
     * @param mixed $screenSize
     * @return TV
     */
    public function setScreenSize($screenSize)
    {
        $this->screenSize = $screenSize;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResolution()
    {
        return $this->resolution;
    }

    /**
     * @param mixed $resolution
     * @return TV
     */
    public function setResolution($resolution)
    {
        $this->resolution = $resolution;
        return $this;
    }

}