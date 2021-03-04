<?php


namespace entities;


use Faker\Factory;

/**
 * Класс текстового примечания
 * */
class IncallNote extends BaseNote
{

    /**
     * Конструктор класса
     * Производит формирование и заполнение полей для запроса
     * @param array $data
     * */
    public function __construct(array $data)
    {
        $faker = Factory::create();
        parent::__construct($data);
        $this->data[0]['params']['uniq'] = $faker->ipv6;
        $this->data[0]['params']['duration'] = $faker->numberBetween(1,59);
        $this->data[0]['params']['source'] = $faker->country;
        $this->data[0]['params']['phone'] = $faker->phoneNumber;
    }
}