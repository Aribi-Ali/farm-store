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
        Schema::create('stores', function (Blueprint $table) {

            $table->id();  // Auto-incrementing primary key
            $table->string('name');  // Store name
            $table->string('slug')->unique();  // Unique store URL slug
            $table->string('logo')->nullable();  // Path to the store's logo
            $table->string('email')->nullable();  // Contact email
            $table->string('phone_number')->nullable();  // Contact phone number
            $table->text('address')->nullable();  // Physical address
            $table->text('description')->nullable();  // Store description
            $table->json('opening_hours')->nullable();  // Store hours (JSON format)
            // $table->string('currency', 10)->default('USD');  // Currency code (e.g., USD, EUR)
            // $table->string('timezone')->default('UTC');  // Timezone (e.g., UTC, Europe/Paris)
            $table->boolean('is_active')->default(true);  // Active status
            $table->boolean('is_featured')->default(false);  // Featured status
            $table->timestamps();  // Created at and updated at timestamps

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
