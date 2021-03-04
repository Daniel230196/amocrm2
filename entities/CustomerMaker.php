<?php


namespace entities;

/**
 * Класс, создающий сущности покупателей
 * */
class CustomerMaker extends EntityMaker
{
    /**
     * Метод, создающий сущность покупателя
     * @return Entity
     **/
    public function makeEntity(): Entity
    {
        return new Customers();
    }
}