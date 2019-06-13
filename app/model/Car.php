<?php

namespace app\model;

use component\exception\CarAttributeException;
use component\exception\CarIdException;
use \stdClass;

/**
 * Class Car
 */
class Car
{
    /**
     * аттрибуты экзмепляра
     */
    protected $id;
    protected $brand = 'неизвестно';
    protected $model = 'неизвестно';
    protected $price;
    protected $status;
    protected $run;
    
    /**
     * @return Car - экземпляр класса
     */
    public function setUniqId()
    {
        $this->id = uniqid('car_', true);
        return $this;
    }
    
    /**
     * @param string $id
     * @return $this
     */
    public function setId(string $id)
    {
        if (strlen($id) > 27) {
            throw new CarIdException('Invalid id');
        }
        $this->id = $id;
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
        if ($price < 0) {
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
        $status = mb_strtolower($status);
        if (!in_array($status, ['в пути', 'на складе', 'продан', 'снят с продажи']) ) {
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
    
    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }
    
    /**
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }
    
    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }
    
    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * @return int
     */
    public function getRun()
    {
        return $this->run;
    }
    
    /**
     * Фабрика
     *
     * @param stdClass $result
     * @return Car
     * @throws CarAttributeException
     */
    public static function createFromDb(stdClass $result): Car
    {
        $car = new Car();
        
        $car->setId($result->car_id)
            ->setBrand($result->brand)
            ->setModel($result->model)
            ->setPrice($result->price)
            ->setStatus($result->status)
            ->setRun($result->run);
        
        return $car;
    }
}