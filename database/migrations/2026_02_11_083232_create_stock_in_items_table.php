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
        Schema::create('stock_in_items', function (Blueprint $table) {
            $table->id();
            $table->string('stock_in_no', 50);
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->decimal('unit_cost', 15, 2);
            $table->decimal('total_cost', 15, 2);
            
            $table->foreign('stock_in_no')->references('stock_in_no')->on('stock_ins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_in_items');
    }
};
