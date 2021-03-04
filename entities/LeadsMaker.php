<?php


namespace entities;

/**
 * Создает сущности сделок и формирует из них список
 * */
class LeadsMaker extends EntityMaker
{
    /**
     * Метод создает сущность сделки
     * @return Leads
     **/
    public function makeEntity(): Leads
    {
        return new Leads();
    }
}