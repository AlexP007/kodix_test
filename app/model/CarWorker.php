<?php

namespace app\model;

use \PDO;
use component\worker\DbWorker;
use app\model\Car;
use component\response\ResponseCarData;
use component\exception\CarIdException;

/**
 * Class CarRecord
 */
class CarWorker extends DbWorker
{
    
    /**
     * @param \app\model\Car|null $car
     * @return \app\model\Car | array 
     * @throws \component\exception\CarIdException
     */
    public function get(Car $car = null)
    {
        if (!$car) {
            $query = "SELECT * FROM {$this->getTableName()}";
            $stmt = $this->PDO->query($query);
    
            $result = [];
            
            while ($exec = $stmt->fetch(PDO::FETCH_OBJ) ) {
                $result[] = new ResponseCarData(Car::createFromDb($exec) );
            }
            return $result;
        } else {
            $query = "SELECT * FROM {$this->getTableName()} WHERE car_id=:id";
            $stmt = $this->PDO->prepare($query);
            $stmt->execute(
                [
                    ':id' => $car->getId()
                ]
            );
    
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            if (!$result) {
                throw new CarIdException('Id does\'t match any data');
            }
            return new ResponseCarData(Car::createFromDb($result) );
        }
        
    }
    
    /**
     * @param \app\model\Car $car
     * @return bool
     */
    public function post(Car $car)
    {
        $query = "INSERT INTO {$this->getTableName()} VALUES(:id, :brand, :model, :price, :status, :run)";
        
        $stmt = $this->PDO->prepare($query);
        
        if ($this->get($car) ) {
            return false;
        }
        $stmt->execute(
            [
                ':id' => $car->getId(),
                ':brand' => $car->getBrand(),
                ':model' => $car->getModel(),
                ':price' => $car->getPrice(),
                ':status' => $car->getStatus(),
                ':run' => $car->getRun(),
            ]
        );
        return true;
    }
    
    /**
     * @param Car $car
     * @return bool
     */
    public function patch(Car $car)
    {
        $attr = [
            'brand' => $car->getBrand(),
            'model' => $car->getModel(),
            'price' => $car->getPrice(),
            'status' => $car->getStatus(),
            'run' => $car->getRun(),
        ];
        
        $changes ='';
        $bindParams = [':id' => $car->getId()];
        
        foreach ($attr as $key => $value) {
            if($value) {
                $changes .= "{$key}=:{$key},";
                $bindParams[":{$key}"] = $value;
            }
        }
        $changes = rtrim($changes, ',');
        $query = "UPDATE {$this->getTableName()} SET {$changes} WHERE car_id=:id";
        $stmt = $this->PDO->prepare($query);
        $stmt->execute($bindParams);
        return true;
    }
    
    public function delete(Car $car)
    {
        $query = "DELETE FROM {$this->getTableName()} WHERE car_id=:id";
        $stmt = $this->PDO->prepare($query);
        $stmt->execute(
            [
                ':id' => $car->getId()
            ]
        );
        return true;
    }
}