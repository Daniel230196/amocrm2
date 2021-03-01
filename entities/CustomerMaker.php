<?php


namespace entities;

/*
 * Класс, создающий сущности покупателей
 * */
class CustomerMaker extends EntityMaker
{

    public function makeEntity(): Entity
    {
        return new Customers();
    }
}