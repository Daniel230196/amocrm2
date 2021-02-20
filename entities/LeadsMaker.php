<?php


namespace entities;

/*
 * Создает сущности сделок и формирует из них список
 * */
class LeadsMaker extends EntityMaker
{
    public function makeEntity(): Leads
    {
        return new Leads();
    }
}