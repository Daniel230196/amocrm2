<?php


namespace entities;


class CompaniesMaker extends EntityMaker
{

    public function makeEntity(): Entity
    {
        return new Companies();
    }
}