<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data', function (Blueprint $table) {
            $table->id();
            $table->integer('total_contract_price');
            $table->string('installment_due', 20);
            $table->string('effective_date', 20);
            $table->string('mode_of_premium', 20);
            $table->string('terms', 20);
            $table->boolean('insurable');
            $table->integer('no_insurable');
            $table->timestamps();
        });

        
        Schema::table('data', function($table) {
            $table->unsignedInteger('planholder_id');
            $table->foreign('planholder_id')->references('id')->on('planholders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data');
    }
}
