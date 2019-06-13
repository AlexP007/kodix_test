<?php

namespace app\controller;

use app\model\Car;
use app\model\Response;
use app\model\CarWorker;
use component\response\ResponseError;

class ApiController
{
    protected $response;
    protected $record;
    protected $car;
    
    public function __construct()
    {
        $this->response = new Response();
        $this->record = new CarWorker();
        $this->car = new Car();
    }
    
    /**
     * Отправляет ошибку
     * об отсутствии корневого элемента запроса
     */
    public function noData()
    {
        $this->response->setSuccess(false)
            ->setHttpStatusCode(422)
            ->addError(
                new ResponseError(
                    [
                        'status' => 422,
                        'source' => ['pointer' => '/'],
                        'detail' => 'Missing `data` Member at document\'s top level.'
                    ]
                )
            )->createResponse()
            ->send();
    }
    
    /**
     * Отправляет ошибку
     * о неверном коревом элементе
     */
    public function invalidDataType()
    {
        $this->response->setSuccess(false)
            ->setHttpStatusCode(422)
            ->addError(
                new ResponseError(
                    [
                        'status' => 422,
                        'source' => ['pointer' => '/data'],
                        'detail' => 'Invalid`data` Member at document\'s top level.'
                    ]
                )
            )
            ->createResponse()
            ->send();
    }
    
    /**
     * Отправляет JSON
     * с данными соответсвующими ID
     */
    public function getById($id)
    {
        $this->car->setId($id);
        $this->response->setSuccess(true)
            ->setHttpStatusCode(200)
            ->addData(
                $this->record->connect()->get($this->car)
            )
            ->createResponse()
            ->send();
    }
    
    /**
     * Отправляет JSON
     * со всеми данными
     */
    public function getAll()
    {
        $this->response->setSuccess(true)
            ->setHttpStatusCode(200)
            ->addData(
                $this->record->connect()->get()
            )
            ->createResponse()
            ->send();
    }
    
    /**
     * Отправляет ошибку
     * об отсутсвтии данных коррелирующих с ID
     */
    public function noId($exception)
    {
        $this->response->setSuccess(false)
            ->setHttpStatusCode(404)
            ->addError(
                new ResponseError(
                    [
                        'status' => 404,
                        'source' => ['pointer' => '/data/id'],
                        'detail' => $exception->getMessage()
                    ]
                )
            )
            ->createResponse()
            ->send();
    }
    
    /**
     * Отправляет ошибку
     * сервера
     */
    public function serverError()
    {
        $this->response->setSuccess(false)
            ->setHttpStatusCode(500)
            ->addError(
                new ResponseError(
                    [
                        'status' => 500,
                    ]
                )
            )
            ->createResponse()
            ->send();
    }
}
