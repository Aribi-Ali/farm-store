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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("SKU")->unique();
            $table->string("name");
            $table->string("description");
            $table->decimal('price', 10, 2);
            $table->decimal("newPrice", 10, 2);
            $table->integer('stock');
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // This line adds the category_id column
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->json('metadata')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreignId('store_id')->constrained()->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
