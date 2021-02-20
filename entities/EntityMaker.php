<?php


namespace entities;
use core;

/*
 * Абстрактный класс для создания списка сущностей
 * */
abstract class EntityMaker
{
    /*
     * Список всех сущностей
     * */
    protected array $data;

    /*
     * Коннект с АПИ
     * */
    protected core\ApiConnection $connection;

    /*
     * Конструктор (добавляет объект ApiConnection для соединения с api)
     * */
    public function __construct()
    {
    }

    /*
     * Получить список сущностей
     * */
    public function getData(): array
    {
        return $this->data;
    }

    /*
     * Формирование списка сущностей
     * В кач-ве аргумента принимает необходимое кол-во сущностей для списка
     * */
    public function makeList(int $count) : array
    {

        for ($i=1; $i<=$count; ++$i){
            $this->data[] = $this->getEntityData();
        }

        return $this->data;
    }

    /*
     * Метод, возвращающий экземпляр сущности
     * */
    abstract protected function makeEntity() : Entity;

    /*
     * Метод, получающий массив значений из сущности
     * */
    protected function getEntityData() : array
    {
        $entity = $this->makeEntity();
        return $entity->getData();
    }
}