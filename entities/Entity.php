<?php

namespace entities;

/*
 * абстрактный класс сущностей
 * */
abstract class Entity
{
    /*
     * Фейкер для заполнения случайными данными
     * */
    protected $faker;

    /*
     * Массив атрибутов сущности
     * */
    protected array $data;

    /*
     * В конструкторе происходит заполнение
     * сущности данными
     * */
    public function __construct()
    {
        $this->faker = \Faker\Factory::create();
        $this->seed();
    }

    /*
     * Абстрактный метод, заполняющий сущность значениями
     * (вызывается в конструкторе)
     * */
    abstract protected function seed();

    /*
     * Метод возвращающий массив данных сущности
     * */
    public function getData() : array
    {
        return $this->data;
    }


}