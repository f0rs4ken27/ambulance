<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmbulancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ambulances', function (Blueprint $table) {
            $table->id();  // Primary key, auto-incrementing
            $table->string('hospital_name');
            $table->string('vehicle_number');  // Vehicle identification number
            $table->string('model');  // Ambulance model or type
            $table->integer('capacity');  // Capacity of the ambulance
            $table->boolean('availability')->default(true);  // Availability status, default is true
            $table->timestamps();  // created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ambulances');
    }
}
