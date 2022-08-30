<?php

namespace Database\Seeders;

use App\Models\Clients;
use App\Models\ClientCars;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientCarsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Clients::factory(10)->create()->each(function($client){
            ClientCars::factory(rand(1,3))->create([
                'client_id' => $client->id
            ]);
        });

    }
}
