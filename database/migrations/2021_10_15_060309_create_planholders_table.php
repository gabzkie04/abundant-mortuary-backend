<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanholdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planholders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('agent_id')->unsigned();
            $table->string('name',50)->unique();
            $table->string('lot_block',255)->nullable();
            $table->string('street',255)->nullable();
            $table->string('barangay',30);
            $table->string('municipality',30);
            $table->string('province',30);
            $table->string('dob',20);
            $table->string('religion',50)->nullable();
            $table->string('contact',20)->nullable();
            $table->string('civil_status',20);
            $table->string('gender',10);
            $table->string('region',30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('planholders');
    }
}
