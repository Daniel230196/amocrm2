<?php

namespace core\test;

class ApiConnectionException extends \Exception
{
    const MESSAGE = 'Api connection error, code: ';
    public function __construct($code, \Throwable $previous = null)
    {
        parent::__construct(self::MESSAGE, $code, $previous);
    }
}