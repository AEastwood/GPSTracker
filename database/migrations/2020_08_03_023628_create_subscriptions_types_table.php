<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 64);
            $table->decimal('cost', 11, 3);
            $table->integer('max_assets')->default(-1);
            $table->integer('max_device')->default(-1);
            $table->integer('max_geofence')->default(-1);
            $table->integer('max_geofence_actions')->default(-1);
            $table->boolean('enabled')->default(0);
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
        Schema::dropIfExists('subscriptions_types');
    }
}
