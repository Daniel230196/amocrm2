<?php


namespace entities;


/**
 * Интерфейс сущеностей-'создателей'
 * */
interface MakerInterface
{
    /**
     * Метод, создающий сущность определенного подкласса
     * @return Entity
     * */
    public function makeEntity() : Entity;
}