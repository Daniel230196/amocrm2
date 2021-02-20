<?php


namespace entities;


class CustomerMaker extends EntityMaker
{

    protected function makeEntity(): Entity
    {
        return new Customers();
    }
}