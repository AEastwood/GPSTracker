<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->string('colour')->nullable();
            $table->string('type')->nullable();
            $table->string('registration')->nullable();
            $table->integer('owner')->nullable();
            $table->string('lat')->nullable();
            $table->string('lon')->nullable();
            $table->integer('speed')->nullable();
            $table->boolean('stolen')->nullable();
            $table->boolean('disabled')->default(0);
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
        Schema::dropIfExists('vehicles');
    }
}
