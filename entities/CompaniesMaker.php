<?php


namespace entities;


class CompaniesMaker extends EntityMaker
{

    public function addComplex()
    {
        $res = $this->connection->add($this);
    }

    protected function makeEntity(): Entity
    {
        return new Companies();
    }
}