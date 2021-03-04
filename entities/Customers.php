<?php


namespace entities;

/**
 * Класс покупателей
 * */
class Customers extends Entity
{
    /**
     * Конструктор класса
     * */
    public function __construct()
    {
        parent::__construct();
        $this->seed();
    }

    /**
     * Заполнение случайными значениями
     * @return void
     * */
    public function seed(): void
    {
        $this->data = [
            'name' => $this->faker->name,
            'next_price' => $this->faker->numberBetween(1, 60000)
        ];
    }

}