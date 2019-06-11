<?php

namespace components\workers;

use components\entities\Car;
use \PDO;
use \PDOException;

require_once $_SERVER['DOCUMENT_ROOT'] ."kodix/constants.php";

/**
 * Class CarRecord
 */
class CarWorker extends DbWorker
{
    /**
     * @param Car $car
     * @return object
     */
    public function find(Car $car)
    {
        $query = "SELECT * FROM {$this->getTableName()} WHERE car_id=:id";
        $stmt = $this->PDO->prepare($query);
        try {
            $stmt->execute(
                [
                    ':id' => $car->getId()
                ]
            );
    
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            return $result;
        }
        catch (PDOException $exception) {
            print "не удалось выполнить запрос";
        }
        
    }
    
    /**
     * @param Car $car
     * @return bool
     */
    public function put(Car $car)
    {
        $query = "INSERT INTO {$this->getTableName()} VALUES(:id, :brand, :model, :price, :status, :run)";
        
        $stmt = $this->PDO->prepare($query);
        
        if ($this->find($car) ) {
            return false;
        }
        try {
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
        catch (PDOException $exception) {
            print "не удалось выполнить запрос";
            
        }
    }
    
    /**
     * @param Car $car
     * @return bool
     */
    public function update(Car $car)
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
        
        print $query;
        print_r($bindParams);
    
        try {
            $stmt->execute($bindParams);
            return true;
        }
        catch (PDOException $exception) {
            print "не удалось выполнить запрос";

        }
        
    }
    
    public function delete(Car $car)
    {
    
        $query = "DELETE FROM {$this->getTableName()} WHERE car_id=:id";
        $stmt = $this->PDO->prepare($query);
        try {
            $stmt->execute(
                [
                    ':id' => $car->getId()
                ]
            );
            
            return true;
        }
        catch (PDOException $exception) {
            print "не удалось выполнить запрос";
        }
    
    }
}