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
        Schema::create('stock_ins', function (Blueprint $table) {
            $table->string('stock_in_no', 50)->primary();
            $table->foreignId('warehouse_id')->constrained('warehouses')->onDelete('cascade');
            $table->string('purchase_order_id', 50)->nullable();
            $table->date('received_date');
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->text('remarks')->nullable();
            $table->timestamps();
            
            $table->index('warehouse_id');
            $table->index('purchase_order_id');
            $table->index('supplier_id');
            $table->index('received_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_ins');
    }
};
