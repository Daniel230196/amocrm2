<?php


namespace entities;
use core\ApiConnection;

/**
 * Абстрактный класс для создания списка сущностей
 * */
abstract class EntityMaker implements MakerInterface
{
    /**
     * Список всех сущностей
     * */
    protected array $data;

    /**
     * Коннект с АПИ
     * */
    protected ApiConnection $connection;

    /**
     * Конструктор (добавляет объект ApiConnection для соединения с api)
     * */
    public function __construct()
    {
    }

    /**
     * Получить список сущностей
     * @return array
     * */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Формирование списка сущностей
     * В кач-ве аргумента принимает необходимое кол-во сущностей для списка
     * @param int $count
     * @return array
     * */
    public function makeList(int $count) : array
    {

        for ($i=1; $i<=$count; ++$i){
            $this->data[] = $this->getEntityData();
        }

        return $this->data;
    }

    /**
     * Метод, возвращающий экземпляр сущности
     * @return Entity
     * */
    abstract public function makeEntity() : Entity;

    /**
     * Метод, получающий массив значений из сущности
     * @return array
     * */
    protected function getEntityData() : array
    {
        $entity = $this->makeEntity();
        return $entity->getData();
    }
}