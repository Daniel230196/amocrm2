<?php


namespace entities;

/**
 * Класс создающий сущности компаний
 * */
class CompaniesMaker extends EntityMaker
{
    /**
     * Метод, создающий сущность определенного типа
     * @return Entity
     * */
    public function makeEntity(): Entity
    {
        return new Companies();
    }
}