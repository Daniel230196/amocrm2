<?php


namespace entities;

/*
 * Класс компаний
 * */

class Companies extends Entity
{
    public function __construct()
    {
        parent::__construct();
        $this->seed();
    }

    public function seed() : void
    {
        $this->data = [
            'name' => $this->faker->colorName,
        ];
    }
}