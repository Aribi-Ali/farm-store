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
        Schema::create('user_badges', function (Blueprint $table) {
            $table->id();  // Unique identifier for each user-badge assignment
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // Foreign key to users table
            $table->foreignId('badge_id')->constrained()->onDelete('cascade');  // Foreign key to badges table
            $table->timestamp('earned_at');  // Date when the badge was earned
            $table->timestamps();  // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_badges');
    }
};
