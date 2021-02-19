<?php


namespace entities;

/*
 * Класс контактов
 *
 * */
class Contacts extends Entity
{
    public function seed() : void
    {
        $this->data = [
            'name' => $this->faker->userName,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
        ];
    }
}