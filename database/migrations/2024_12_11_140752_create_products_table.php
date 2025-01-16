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

            // Identification and General Information
            $table->id();
            $table->string("SKU")->unique()->comment('Unique Stock Keeping Unit');
            $table->string("name")->comment('Product name');
            $table->string("description")->nullable()->comment('Short description of the product');
            $table->boolean('isActive')->default(true)->comment('Product visibility status');
            $table->unsignedInteger('priority')->default(0)->comment('Sort order priority');

            // Pricing
            $table->decimal('price', 10, 2)->comment('Base price');
            $table->decimal("newPrice", 10, 2)->nullable()->comment('Discounted or promotional price');
            $table->decimal("specialPrice", 10, 2)->nullable()->comment('Special promotional price');
            $table->date('specialPriceStartDate')->nullable()->comment('Start date for special price');
            $table->date('specialPriceEndDate')->nullable()->comment('End date for special price');

            // Stock and Inventory
            $table->integer('stock')->default(0)->comment('Available stock count');

            // Relationships
            $table->foreignId('category_id')
                ->constrained()
                ->onDelete('cascade')
                ->comment('Associated category ID');

            $table->foreignId('store_id')
                ->constrained()
                ->onDelete('cascade')
                ->comment('Store owner ID');

            $table->foreignId('brand_id')
                ->nullable()
                ->constrained()
                ->onDelete('set null')
                ->comment('Associated brand ID');

            $table->unsignedBigInteger('created_by')->nullable()->comment('User who created the product');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('User who last updated the product');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');

            // Shipping
            $table->boolean('hasCustomShipping')->default(false)->comment('Flag for custom shipping');
            $table->decimal('homeCustomShipping_cost', 8, 2)->nullable()->comment('Cost for home delivery');
            $table->decimal('stopDeskCustomShipping_cost', 8, 2)->nullable()->comment('Cost for stop-desk delivery');
            $table->boolean('freeShipping')->default(false)->comment('Indicates if shipping is free');

            // Images
            $table->string('thumbnailImage')->nullable()->comment('Primary thumbnail image URL');
            $table->string('secondaryImage')->nullable()->comment('Secondary image URL');

            // Metadata
            $table->json('metadata')->nullable()->comment('Additional metadata in JSON format');

            // Audit and Tracking
            $table->unsignedBigInteger('viewsCount')->default(0)->comment('Total number of views');
            $table->unsignedBigInteger('salesCount')->default(0)->comment('Total number of sales');
            $table->decimal('rating', 3, 2)->default(100)->comment('Product average rating');

            // Indexes
            $table->index(['category_id', 'store_id', 'isActive']);
            $table->index(['price', 'priority']);

            // Timestamps and Soft Deletes
            $table->timestamps();
            $table->softDeletes();
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
