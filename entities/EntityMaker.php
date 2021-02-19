<?php


namespace entities;
use core;

/*
 * Абстрактный класс для создания списка сущностей
 * */
abstract class EntityMaker
{
    /*
     * Список всех сущностей одного типа
     * */
    protected array $data;

    /*
     * Метод для соединения с АПИ
     * */
    protected string $path;

    /*
     * Коннект с АПИ
     * */
    protected core\ApiConnection $connection;

    /*
     * Конструктор (добавляет объект ApiConnection для соединения с api)
     * */
    public function __construct()
    {
        $this->connection = core\ApiConnection::getInstance();
    }

    /*
     * Получить список сущностей
     * */
    public function getData(): array
    {
        return $this->data;
    }

    /*
     * Получить метод для АПИ
     * */
    public function getPath() : string
    {
        return $this->path;
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
     * Метод , реализующий комплексное добавление списка сущностей
     * */
    abstract public function addComplex();

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