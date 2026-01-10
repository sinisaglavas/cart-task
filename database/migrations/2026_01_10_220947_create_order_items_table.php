<?php

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
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
        Schema::create(OrderItem::TABLE, function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained(Order::TABLE)->cascadeOnDelete();
            $table->foreignId('product_id')->constrained(Product::TABLE)->cascadeOnDelete();
            $table->unsignedInteger('quantity');
            $table->decimal('price_at_time', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(OrderItem::TABLE);
    }
};
