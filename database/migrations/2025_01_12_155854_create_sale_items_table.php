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
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained()->onDelete('cascade'); // Links to sales table
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Product sold
            $table->integer('quantity'); // Quantity of product
            $table->decimal('price_per_unit', 8, 2); // Price per unit at the time of sale
            $table->decimal('total_price', 10, 2); // Total price for this item
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_items');
    }
};



// code for update sales
/*
$sale = Sale::create([
    'order_id' => $order->id,
    'store_id' => $order->store_id,
    'customer_id' => $order->customer_id,
    'total_amount' => $order->total,
    'sale_date' => now(),
]);

foreach ($order->items as $item) {
    SaleItem::create([
        'sale_id' => $sale->id,
        'product_id' => $item->product_id,
        'quantity' => $item->quantity,
        'price_per_unit' => $item->price,
        'total_price' => $item->quantity * $item->price,
    ]);
}
*/

// command for daily updates
/*
Artisan::command('analytics:update-daily-sales', function () {
    // Compute daily sales metrics and update 'daily_sales' table
})->describe('Update daily sales analytics.');

*/
