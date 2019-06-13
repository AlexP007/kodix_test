<?php

namespace app\controller;

class Router
{
    protected $type;
    protected $id;
    
    public function __construct()
    {
        $this->setType()
             ->setId();
    }
    
    /**
     * Парсит корневой элемент запроса
     *
     * @return $this
     */
    public function setType()
    {
        $type = isset($_GET['type']) ? $_GET['type'] : null;
        $this->type = filter_var($type, FILTER_SANITIZE_MAGIC_QUOTES);
        print $type;
        print '<br>';
        return $this;
    }
    
    /**
     * Парсит id
     *
     * @return $this
     */
    public function setId()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $this->id = filter_var($id, FILTER_SANITIZE_MAGIC_QUOTES);
        return $this;
    }
    
    public function getType()
    {
        return $this->type;
    }
    
    public function getId()
    {
        return $this->id;
    }
}
