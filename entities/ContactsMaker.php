<?php


namespace entities;


class ContactsMaker extends EntityMaker
{

    public function makeEntity(): Entity
    {
        return new Contacts();
    }
}