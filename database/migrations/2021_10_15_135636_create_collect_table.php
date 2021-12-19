<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collect', function (Blueprint $table) {
            $table->id();
            $table->string('amount',50);
            $table->string('or_number',50);
            $table->string('date_collect', 20);
            $table->timestamps();
            $table->integer('number_of_months_collected');
        });

        Schema::table('collect', function($table) {
            $table->unsignedInteger('planholder_id');
            $table->foreign('planholder_id')->references('id')->on('planholders')->onDelete('cascade');

            $table->unsignedInteger('collector_id');
            $table->foreign('collector_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collect');
    }
}
