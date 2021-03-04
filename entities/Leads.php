<?php


namespace entities;

/**
 * Класс сделок
 * */
class Leads extends Entity
{


    /**
     * Конструктор класса
     * производит заполнение полей значениями
     * */
    public function __construct()
    {
        parent::__construct();
        $this->seed();
    }

    /**
     * Заполнение полей сущности значениями
     * @return void
     * */
    public function seed() : void
    {
        $this->data = [
            'name' => $this->faker->jobTitle,
            'price' => $this->faker->numberBetween(1,100),
            '_embedded' => [
                'contacts' => [],
                'companies' => [],
            ]
        ];
    }
}