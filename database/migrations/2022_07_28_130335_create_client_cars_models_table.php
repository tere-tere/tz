<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('client_cars', function (Blueprint $table) {
            $table->unsignedMediumInteger("id_client_car");
            $table->string("mark","50");
            $table->string("model","50");
            $table->string("color","50");
            $table->string("gos_number","9")->unique(); 
            $table->boolean("car_in_place");

            $table->foreign('id_client_car')->references('id_client_car')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    ///
    public function down()
    {
        Schema::dropIfExists('client_cars');
    }
};
