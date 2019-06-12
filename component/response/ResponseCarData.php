<?php


namespace component\response;

use ReflectionClass;
use app\model\Car;

class ResponseCarData extends ResponseBasic
{
    public $type = 'car';
    public $id;
    public $brand;
    public $model;
    public $price;
    public $status;
    public $run;
    
    public function __construct(Car $car)
    {
        $info = [];
        $props = (new ReflectionClass($car))->getProperties();
        foreach ($props as $value) {
            $prop = "get" . ucfirst($value->name);
            $info[$value->name] = $car->$prop();
        }
        parent::__construct($info);
    }
}