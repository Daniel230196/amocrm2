<?php


namespace entities;

/*
 * Класс создающий сущности компаний
 * */
class CompaniesMaker extends EntityMaker
{

    public function makeEntity(): Entity
    {
        return new Companies();
    }
}