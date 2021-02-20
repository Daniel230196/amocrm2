<?php


namespace entities;

/*
 * Класс покупателей
 * */

class Customers extends Entity
{
    public function __construct()
    {
        parent::__construct();
        $this->seed();
    }

    public function seed(): void
    {
        $this->data = [
            'name' => $this->faker->name,
            'next_price' => $this->faker->numberBetween(1, 60000)
        ];
    }

}