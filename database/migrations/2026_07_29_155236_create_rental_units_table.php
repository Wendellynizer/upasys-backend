<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rental_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_owner_id')->constrained('users');
            $table->string('unit_name');
            $table->string('description')->nullable();
            $table->decimal('base_rent_amount');
            $table->foreignId('payment_frequency_id')->constrained();
            $table->boolean('is_available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rental_units', function (Blueprint $table) {
            //
        });
    }
};
