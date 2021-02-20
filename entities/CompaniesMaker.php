<?php


namespace entities;


class CompaniesMaker extends EntityMaker
{

    protected function makeEntity(): Entity
    {
        return new Companies();
    }
}