<?php

namespace Database\Factories;
use App\Models\CLients;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clients>
 */
class ClientsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'fio' => fake('ru_RU')->name,
            'gender'=> fake()->randomElement(['f','m']),
            'phone'=>  fake()->unique()->numerify('79#########'),
            'address'=> fake('ru_RU')->address()
        ];
    }
}
