<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();  // Primary key, auto-incrementing
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');  // Foreign key to users table
            $table->foreignId('ambulance_id')->constrained('ambulances')->onDelete('cascade');  // Foreign key to ambulances table
            $table->string('license_number');  // Driver's license number
            $table->string('vehicle_registration');  // Vehicle registration number
            $table->boolean('availability')->default(true);  // Availability status, default is available (true)
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
        Schema::dropIfExists('drivers');
    }
}
