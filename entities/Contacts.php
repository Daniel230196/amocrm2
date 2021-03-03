<?php


namespace entities;

/*
 * Класс контактов
 *
 * */
class Contacts extends Entity
{
    /*
     * Значения мультисписка
     * */
    private array $multiselectId = [
        268519,268521,268523,268525,268527,268529,268531,268533,268535,268537
    ];
    public function seed(): void
    {
        $this->data = [
            'name' => $this->faker->userName,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'custom_fields_values' => [
            ]

        ];
        $this->multiselect();
    }

    /*
     * метод для заполнения поля "мультисписок"
     * */
    private function multiselect()
    {
        $multiValues = [];
        for ($i=0; $i<=9; ++$i){
            $multiValues[$i] = ['enum_id' => $this->faker->randomElement($this->multiselectId)];
        }
        $this->data['custom_fields_values'] = [
            [
                'field_id' => 506559,
                'values' => $multiValues,
            ]
        ];
    }


}