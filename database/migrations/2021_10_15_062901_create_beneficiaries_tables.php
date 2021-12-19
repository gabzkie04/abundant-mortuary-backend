<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeneficiariesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficiaries_tables', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->string('dob',20);
            $table->string('address', 50);
            $table->string('relationship', 30);
            $table->timestamps();
        });
                
        Schema::table('beneficiaries_tables', function($table) {
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
        Schema::dropIfExists('beneficiaries_tables');
    }
}
