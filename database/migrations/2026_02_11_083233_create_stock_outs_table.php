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
        Schema::create('stock_outs', function (Blueprint $table) {
            $table->string('stock_out_no', 50)->primary();
            $table->foreignId('warehouse_id')->constrained('warehouses')->onDelete('cascade');
            $table->string('billing_id', 50)->nullable();
            $table->date('issued_date');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('stock_out_type', ['ส่งขายให้ลูกค้า', 'ใช้งานภายใน', 'ส่งซ่อม', 'อื่นๆ'])->default('ส่งขายให้ลูกค้า');
            $table->text('remarks')->nullable();
            $table->timestamps();
            
            $table->index('warehouse_id');
            $table->index('billing_id');
            $table->index('user_id');
            $table->index('issued_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_outs');
    }
};
