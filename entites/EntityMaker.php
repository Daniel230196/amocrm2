<?php


namespace entities;



abstract class EntityMaker
{
    /*
     * Список всех сущностей
     * */
    protected array $data;
    /*
     * Метод, заполняющий сущность значениями
     * */
    abstract public function seedAttributes();
    /*
     * Метод, возвращающий экземпляр сущности
     * */
    abstract public function makeEntity() : Entity;
}