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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('orderNumber')->unique();
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->foreignId("store_id")->constrained()->onDelete("cascade");
            $table->enum('status', ['pending', 'processing', 'completed', 'decline'])->default('pending');
            $table->decimal('grandTotal', 20, 6);
            $table->unsignedInteger('itemCount');
            // $table->boolean('payment_status')->default(1);
            // $table->string('payment_method')->nullable();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('city');
            $table->text('address');
            $table->string('phoneNumber');
            $table->text('notes')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};