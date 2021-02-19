<?php


namespace entities;


class CustomerMaker extends EntityMaker
{

    public function addComplex()
    {
        $res = $this->connection->add($this);
    }

    protected function makeEntity(): Entity
    {
        return new Customers();
    }
}