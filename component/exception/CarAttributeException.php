<?php

namespace component\exception;
use \Exception;
use Throwable;

/**
 * Class CarAttributeException
 *
 * исключеиние - ошибка назначения аттрибута
 * экземпляру Car
 */
class CarAttributeException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}