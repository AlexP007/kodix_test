<?php

namespace component\worker;

use app\model\Car;
use \ReflectionClass;
use \PDO;
use \PDOException;

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
     * @return $this|bool
     */
    public function connect()
    {
        $dsn = DB_TYPE . ":dbname={$this->getDbName()};host=" . DB_HOST . ";charset=utf8";
        $this->PDO = new PDO($dsn, DB_USER, DB_PASSWORD);

        return $this;
    }
    
    abstract public function get(Car $car);
    abstract public function post(Car $car);
    abstract public function patch(Car $car);
    abstract public function delete(Car $car);
}