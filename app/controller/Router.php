<?php

namespace app\controller;

use component\exception\TypeException;

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
    
    /**
     * Проверяем на:
     * Content-Type: application/vnd.api+json
     * Accept: application/vnd.api+json
     */
    public function checkType()
    {
        if ($_SERVER['CONTENT_TYPE'] !== 'application/vnd.api+json') {
            throw new TypeException('Invalid content-type');
        }
        if ($_SERVER['HTTP_ACCEPT'] !== 'application/vnd.api+json') {
            throw new TypeException('Invalid accept header');
        }
        return true;
    }
    
    public function getPost()
    {
        $raw = file_get_contents('php://input');
        $json = json_decode(
            filter_var(
                $raw,
                FILTER_SANITIZE_STRING,
                FILTER_FLAG_NO_ENCODE_QUOTES
            )
        );
        return $json;
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
