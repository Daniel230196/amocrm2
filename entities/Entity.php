<?php

namespace entities;

/**
 * Абстрактный класс сущностей
 * */
abstract class Entity
{
    /**
     * Фейкер для заполнения данными
     * */
    protected $faker;

    /**
     * Массив атрибутов сущности
     * */
    protected array $data;

    /**
     * В конструкторе происходит заполнение
     * сущности данными
     * */
    public function __construct()
    {
        $this->faker = \Faker\Factory::create();
        $this->seed();
    }

    /**
     * Абстрактный метод, заполняющий сущность значениями
     * (вызывается в конструкторе)
     * @return void
     * */
    abstract protected function seed() : void;

    /**
     * Метод возвращающий массив данных сущности
     * @return array
     * */
    public function getData() : array
    {
        return $this->data;
    }


}