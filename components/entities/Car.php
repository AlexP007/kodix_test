<?php

namespace components\entities;

use components\exceptions\CarAttributeException;

/**
 * Class Car
 */
class Car
{
    /**
     * аттрибуты экзмепляра
     */
    protected $id;
    protected $brand;
    protected $model;
    protected $price;
    protected $status;
    protected $run;
    
    /**
     * @return Car - экземпляр класса
     */
    public function setId()
    {
        $this->id = uniqid('car_', true);
        return $this;
    }
    
    /**
     * @param string $brand
     * @return $this
     */
    public function setBrand(string $brand)
    {
        $this->brand = $brand;
        return $this;
    }
    
    /**
     * @param string $model
     * @return $this
     */
    public function setModel(string $model)
    {
        $this->model = $model;
        return $this;
    }
    
    
    /**
     * @param int $price
     * @throws CarAttributeException
     * @return $this
     */
    public function setPrice(int $price)
    {
        if ($price <0) {
            throw new CarAttributeException('цена не может быть меньше нуля');
        }
        $this->price = $price;
        return $this;
    }
    
    /**
     * @param string $status
     * @return $this
     * @throws CarAttributeException
     */
    public function setStatus(string $status)
    {
        if (!in_array($status, ['В пути', 'На складе', 'Продан', 'Снят с продажи']) ) {
            throw new CarAttributeException('статус должен быть: (В пути, На складе, Продан, Снят с продажи)');
        }
        $this->status = $status;
        return $this;
    }
    
    /**
     * @param int $run
     * @return $this
     * @throws CarAttributeException
     */
    public function setRun(int $run)
    {
        if ($run <0) {
            throw new CarAttributeException('пробег не может быть отрицательным');
        }
        $this->run = $run;
        return $this;
    }
}