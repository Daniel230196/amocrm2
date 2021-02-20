<?php


namespace entities;


class ContactsMaker extends EntityMaker
{

    protected function makeEntity(): Entity
    {
        return new Contacts();
    }
}