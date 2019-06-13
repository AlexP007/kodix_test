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
     * о неверных заголовках
     */
    public function typeError($exception)
    {
        $this->response->setSuccess(false)
            ->setHttpStatusCode(400)
            ->addError(
                new ResponseError(
                    [
                        'status' => 400,
                        'detail' => $exception->getMessage()
                    ]
                )
            )
            ->createResponse()
            ->send();
    }
    
    /**
     * Отправляет ошибку
     * о неверном формате json
     */
    public function jsonError()
    {
        $this->response->setSuccess(false)
            ->setHttpStatusCode(400)
            ->addError(
                new ResponseError(
                    [
                        'status' => 400,
                        'detail' => 'Неверный формат JSON'
                    ]
                )
            )
            ->createResponse()
            ->send();
    }
    
    /**
     * Отправляет ошибку
     * о значении аттрибута
     */
    public function attrError($exception)
    {
        $this->response->setSuccess(false)
            ->setHttpStatusCode(400)
            ->addError(
                new ResponseError(
                    [
                        'status' => 400,
                        'detail' => $exception->getMessage()
                    ]
                )
            )
            ->createResponse()
            ->send();
    }
    
    /**
     * Добавляет объект в бд
     */
    public function post($data)
    {
        if (
            $data->brand
            && $data->model
            && $data->price
            && $data->status
            && $data->run
        ) {
    
            $this->car
                ->setUniqId()
                ->setBrand($data->brand)
                ->setModel($data->model)
                ->setPrice($data->price)
                ->setStatus($data->status)
                ->setRun($data->run);
    
            $this->record->connect()->post($this->car);
            $this->response->setSuccess(true)
                ->setHttpStatusCode(201)
                ->addData(
                    $this->record->connect()->get($this->car)
                )
                ->createResponse()
                ->send();
        } else {
            $this->response->setSuccess(false)
                ->setHttpStatusCode(400)
                ->addError(
                    new ResponseError(
                        [
                            'status' => 400,
                            'detail' => 'Неправильное значение data'
                        ]
                    )
                )
                ->createResponse()
                ->send();
        }
    }
    
    public function patch($data)
    {
        
        $vars = get_object_vars($data);
        foreach ($vars as $key => $value) {
            $method = "set" . $key;
            $this->car->$method($value);
        }
        if ($this->record->connect()->get($this->car) ) {
            $this->record->patch($this->car);
            $this->response->setSuccess(true)
                ->setHttpStatusCode(202)
                ->addData(
                    $this->record->get($this->car)
                )
                ->createResponse()
                ->send();
        };
    }
    
    /**
     * Удаляет объект в бд
     */
    public function deleteById($id)
    {
        if ($this->record->connect()->delete($this->car->setId($id)) ) {
            $this->response->setSuccess(true)
                ->setHttpStatusCode(200)
                ->send();
        } else {
            $this->response->setSuccess(false)
                ->setHttpStatusCode(404)
                ->addError(
                    new ResponseError(
                        [
                            'status' => 404,
                        ]
                    )
                )
                ->createResponse()
                ->send();
        }
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
