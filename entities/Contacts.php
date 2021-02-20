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
            '_embedded' => [
                'custom_fields' => [
                    [
                        'name' => 'multi select',
                        'type' =>'multiselect',
                        'enums' => [
                            ['value' => $this->faker->phoneNumber],
                            ['value' => $this->faker->phoneNumber],
                            ['value' => $this->faker->phoneNumber],
                            ['value' => $this->faker->phoneNumber],
                            ['value' => $this->faker->phoneNumber],
                            ['value' => $this->faker->phoneNumber],
                            ['value' => $this->faker->phoneNumber],
                            ['value' => $this->faker->phoneNumber],
                            ['value' => $this->faker->phoneNumber],
                            ['value' => $this->faker->phoneNumber]
                        ]
                    ]
                ]
            ]

        ];

    }

}