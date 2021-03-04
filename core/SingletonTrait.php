<?php


namespace core;

/**
 * Трейт - синглтон со встроенной инициализацией в методе получения
 * */
trait SingletonTrait
{
    /**
     * Инстанс создаваемой сущности
     * */
    private static $instance;

    /**
     * Метод, организующий инициализацию создаваемой сущности
     * */
    abstract public static function init();

    /**
     * Основной метод трейта. Возвращает сущность в единственном экземпляре
     * */
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