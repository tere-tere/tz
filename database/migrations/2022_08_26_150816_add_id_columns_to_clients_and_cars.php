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
        Schema::table('client_cars', function (Blueprint $table) {
            $table->dropForeign(['id_client_car']);
            $table->dropColumn('id_client_car');
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('id_client_car');
        });

        //чтобы удалить связь(ключи) нужно отдельно все делать ...
        Schema::table('clients', function (Blueprint $table) {
            $table->id('id')->first();
        });
        Schema::table('client_cars', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->first();
            $table->foreign('client_id')->references('id')->on('clients');

            $table->id('id')->first();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_cars', function (Blueprint $table) {
//            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
            $table->dropColumn('id');
        });
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('id');
        });
        Schema::table('clients', function (Blueprint $table) {
            $table->mediumIncrements('id_client_car')->first();

        });
        Schema::table('client_cars', function (Blueprint $table) {
            $table->unsignedMediumInteger('id_client_car');
            $table->foreign('id_client_car')->references('id_client_car')->on('clients');

        });
    }
};