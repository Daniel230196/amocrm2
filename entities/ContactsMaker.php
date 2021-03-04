<?php


namespace entities;

/**
 * Класс, создающий сущности контактов
 * */
class ContactsMaker extends EntityMaker
{
    /**
     * Метод создания сущности контакта
     * @return Entity
     **/
    public function makeEntity(): Entity
    {
        return new Contacts();
    }
}