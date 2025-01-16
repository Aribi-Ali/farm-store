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
        Schema::create('images', function (Blueprint $table) {
            $table->id();

            // Foreign Keys
            $table->foreignId('product_id')
                ->constrained()
                ->onDelete('cascade')
                ->comment('Associated product ID');

            // Attributes
            $table->unsignedInteger('priority')
                ->default(0)
                ->comment('Priority for image display order (lower means higher priority)');



            

            // Timestamps
            $table->timestamps();

            // Indexes
            $table->index(['product_id', 'priority'], 'product_priority_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
