<?php


namespace app\model;

use component\response\ResponseCarData;
use component\response\ResponseError;
use component\response\ResponseMeta;

class Response
{
    protected $jsonApi = ["version" => "1.0"];
    protected $success = true;
    protected $httpStatusCode = '200';
    protected $responseData = array();
    protected $errors = array();
    protected $data = array();
    protected $meta = null;
    
    /**
     * @param bool $success
     * @return $this
     */
    public function setSuccess(bool $success)
    {
        $this->success = $success;
        return $this;
    }
    
    /**
     * @param int $code
     * @return $this
     */
    public function setHttpStatusCode(int $code)
    {
        $this->httpStatusCode = $code;
        return $this;
    }
    
    /**
     * @param ResponseCarData $data
     * @return $this
     */
    public function addData(ResponseCarData $data)
    {
        $this->data[] = $data;
        return $this;
    }
    
    /**
     * @param ResponseError $err
     * @return $this
     */
    public function addError(ResponseError $err)
    {
        $this->errors[] = $err;
        return $this;
    }
    
    /**
     * @param ResponseMeta $meta
     * @return $this
     */
    public function addMeta(ResponseMeta $meta)
    {
        $this->meta = $meta;
        return $this;
    }
    
    /**
     * формирует объект ответа
     *
     * @return $this
     */
    public function createResponse()
    {
        if ($this->meta) {
            $this->responseData['meta'] = $this->meta;
        }
        if ($this->success) {
            $this->responseData['data'] = $this->data;
        }
        else {
            $this->responseData['errors'] = $this->errors;
        }
        return $this;
    }
    
    /**
     * отправляет необходимые заголовки и ответ
     */
    public function send()
    {
        header('Content-Type: application/vnd.api+json');
        header('Cache-control: no-cache, no-store');
        header("Cache-Control: max-age=0");
        http_response_code($this->httpStatusCode);
        print json_encode($this->responseData, JSON_UNESCAPED_UNICODE);

    }
}