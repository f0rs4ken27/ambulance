<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_rates', function (Blueprint $table) {
            $table->id();  // Primary key, auto-incrementing
            $table->foreignId('office_id')->constrained('offices')->onDelete('cascade');  // Foreign key to offices table
            $table->enum('service_type', ['transport_sick', 'transport_deceased']);  // Type of service
            $table->time('hour_start');  // Start hour for the rate
            $table->time('hour_end');  // End hour for the rate
            $table->decimal('rate_per_km', 8, 2);  // Rate per kilometer
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
        Schema::dropIfExists('service_rates');
    }
}
