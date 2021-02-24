<?php


namespace core;


trait SingletonTrait
{
    private static $instance;

    final public static function getInstance()
    {
        if (!isset(static::$instance)){
            static::$instance = new static;
        }
        return static::$instance;
    }
}