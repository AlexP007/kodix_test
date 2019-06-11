<?php

namespace components\workers;

use components\entities\Car;
use \ReflectionClass;
use \PDO;
use \PDOException;

require_once $_SERVER['DOCUMENT_ROOT'] ."/constants.php";

/**
 * Abstract Class DbRecord
 */
abstract class DbWorker
{
    protected $dbName;
    protected $tableName;
    protected $PDO;
    
    public function __construct()
    {
        $tableName = (new ReflectionClass($this))->getShortName();
        $tableName = str_replace('Worker', '', $tableName);
        $this->setDbName(DB_NAME)
             ->setTableName($tableName);
    }
    
    /**
     * @param string $name
     * @return $this
     */
    protected function setDbName(string $name)
    {
        $this->dbName = $name;
        return $this;
    }
    
    /**
     * @param string $name
     * @return $this
     */
    protected function setTableName(string $name)
    {
        $this->tableName = $name;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getDbName()
    {
        return $this->dbName;
    }
    
    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }
    
    /**
     * @return $this
     */
    public function connect()
    {
        $dsn = DB_TYPE . ":dbname={$this->getDbName()};host=" . DB_HOST;
        try {
            $this->PDO = new PDO($dsn, DB_USER, DB_PASSWORD);
        }
        catch (PDOException $exception) {
            print 'не удалось подключиться к базе';
        }
        return $this;
    }
    
    abstract public function find(Car $car);
    abstract public function put(Car $car);
    abstract public function update(Car $car);
    abstract public function delete(Car $car);
}