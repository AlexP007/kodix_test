<?php

namespace components\exceptions;
use \Exception;
use Throwable;

/**
 * Class CarException
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