<?php


namespace entities;


class CustomerMaker extends EntityMaker
{

    public function makeEntity(): Entity
    {
        return new Customers();
    }
}