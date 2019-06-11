<?php

namespace components\records;

use \ReflectionClass;
use \PDO;
use \PDOException;

require_once $_SERVER['DOCUMENT_ROOT'] ."/constants.php";

/**
 * Abstract Class DbRecord
 */
abstract class DbRecord
{
    protected $dbName;
    protected $tableName;
    protected $db;
    
    public function __construct()
    {
        $tableName = (new ReflectionClass($this))->getShortName();
        $tableName = str_replace('Record', '', $tableName);
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
    
    public function connect()
    {
        $dsn = DB_TYPE . ":dbname={$this->getDbName()};host=" . DB_HOST;
        try {
            $this->db = new PDO($dsn, DB_USER, DB_PASSWORD);
        }
        catch (PDOException $exception) {
            print 'не удалось подключиться к базе';
        }
    }
}