<?php


namespace component\exception;


use Exception;
use Throwable;

/**
 * Class TypeException
 *
 * исключеиние - ошибка заголовков
 */
class TypeException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}