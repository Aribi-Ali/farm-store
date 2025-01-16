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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Links to the order
            $table->foreignId('store_id')->constrained()->onDelete('cascade'); // Store information
            $table->foreignId('customer_id')->nullable()->constrained('users')->onDelete('set null'); // If registered customer
            $table->decimal('total_amount', 10, 2); // Total sale amount
            $table->timestamp('sale_date'); // Timestamp of sale completion
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
