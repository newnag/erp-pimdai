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
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->string('stock_no', 50)->primary();
            $table->foreignId('warehouse_id')->constrained('warehouses')->onDelete('cascade');
            $table->enum('movement_type', ['IN', 'OUT', 'ADJUSTMENT']);
            $table->string('reason')->nullable();
            $table->date('movement_date');
            $table->text('remarks')->nullable();
            $table->timestamp('created_at')->useCurrent();
            
            $table->index('warehouse_id');
            $table->index('movement_date');
            $table->index('movement_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
