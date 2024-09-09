<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rides', function (Blueprint $table) {
            $table->id();  // Primary key, auto-incrementing
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');  // Foreign key to users table (customer)
            $table->foreignId('driver_id')->constrained('drivers')->onDelete('cascade');  // Foreign key to drivers table
            $table->foreignId('ambulance_id')->constrained('ambulances')->onDelete('cascade');  // Foreign key to ambulances table
            $table->string('pickup_location');  // Pickup location
            $table->string('dropoff_location');  // Dropoff location
            $table->float('distance_km');  // Distance in kilometers
            $table->enum('service_type', ['transport_sick', 'transport_deceased']);  // Service type
            $table->decimal('rate_per_km', 8, 2);  // Rate per kilometer
            $table->decimal('total_cost', 10, 2);  // Total cost of the ride
            $table->enum('payment_status', ['pending', 'paid']);  // Payment status
            $table->foreignId('payment_method_id')->constrained('payment_methods')->onDelete('cascade');  // Foreign key to payment methods table
            $table->enum('status', ['requested', 'accepted', 'in_progress', 'completed', 'canceled']);  // Ride status
            $table->timestamp('requested_at')->nullable();  // Time the ride was requested
            $table->timestamp('started_at')->nullable();  // Time the ride started
            $table->timestamp('completed_at')->nullable();  // Time the ride was completed
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
        Schema::dropIfExists('rides');
    }
}
