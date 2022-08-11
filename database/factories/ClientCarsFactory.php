<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use \Faker\Provider\FakerCar;
use App\Models\CLients;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClientCars>
 */
class ClientCarsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        //добавлена библиотека которая генериует значение для таблицы client_cars
        $faker = (new \Faker\Factory())::create();
        $faker->addProvider(new \Faker\Provider\Fakecar($faker));
        $br_md = $faker->vehicleArray; //brand and model
        return [
            'id_client_car'=> Clients::inRandomOrder()->first(),
            'mark'=> $br_md['brand'],
            'model'=> $br_md['model'],
            'color'=> fake()->colorName('ru_RU'),
            'gos_number'=> $faker->randomElement([$faker->vehicleRegistration('[A-Z]{1}[0-9]{3}[A-Z]{1} [0-9]{3}'),$faker->vehicleRegistration('[A-Z]{1}[0-9]{3}[A-Z]{1} [0-9]{2}')]),
            'car_in_place'=> fake()->boolean(),
        ];
    }
}
