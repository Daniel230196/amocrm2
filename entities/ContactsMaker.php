<?php


namespace entities;


class ContactsMaker extends EntityMaker
{

    public function addComplex()
    {
        $res = $this->connection->add($this);
    }

    protected function makeEntity(): Entity
    {
        return new Contacts();
    }
}