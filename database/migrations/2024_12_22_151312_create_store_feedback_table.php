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
        Schema::create('store_feedback', function (Blueprint $table) {

            $table->foreignId('store_id')->constrained()->cascadeOnDelete(); // Reference to products table
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // Reference to users table (optional)
            $table->tinyInteger('rating')->unsigned()->comment('Rating between 1 and 5');
            $table->text('reviewText')->nullable()->comment('Optional review text');
            $table->unique(['store_id', 'user_id'], 'unique_user_store_feedback');
            $table->timestamps(); // created_at and updated_at

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_feedback');
        Schema::dropUnique('unique_user_store_feedback');
    }
};
