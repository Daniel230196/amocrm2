<?php


namespace core;


trait SingletonTrait
{
    private static $instance;

    abstract public static function init();

    final public static function getInstance()
    {
        static::init();

        if (!isset(static::$instance)){
            static::$instance = new static;
        }
        return static::$instance;
    }
    protected function __construct()
    {
    }
    protected function __clone()
    {
    }

    protected function __wakeup()
    {
    }

}