<?php


namespace entities;

/*
 * Класс, создающий сущности контактов
 * */
class ContactsMaker extends EntityMaker
{

    public function makeEntity(): Entity
    {
        return new Contacts();
    }
}