<?php


namespace entities;

/**
 * Класс компаний
 * */
class Companies extends Entity
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
    public function seed() : void
    {
        $this->data = [
            'name' => $this->faker->colorName,
        ];
    }
}