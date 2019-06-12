<?php

namespace component\exception;
use \Exception;
use Throwable;

/**
 * Class CarIdException
 *
 * исключеиние - ошибкаid
 * экземпляру Car
 */
class CarIdException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
