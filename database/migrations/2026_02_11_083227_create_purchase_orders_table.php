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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->string('po_no', 50)->primary();
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('order_date');
            $table->date('expected_date')->nullable();
            $table->integer('credit')->default(0);
            $table->enum('status', ['Draft', 'Sent', 'Confirmed', 'Received', 'Cancelled'])->default('Draft');
            $table->string('no_ref', 100)->nullable();
            $table->enum('type_price', ['ราคาไม่รวมภาษี', 'ราคารวมภาษี'])->default('ราคาไม่รวมภาษี');
            $table->foreignId('warehouse')->nullable()->constrained('warehouses')->onDelete('set null');
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('discount_percent', 5, 2)->default(0);
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('tax_amount', 15, 2)->default(0);
            $table->decimal('grand_total', 15, 2)->default(0);
            $table->decimal('withholding_tax', 15, 2)->default(0);
            $table->text('remark')->nullable();
            $table->text('notes')->nullable();
            $table->string('link_file', 500)->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('supplier_id');
            $table->index('user_id');
            $table->index('order_date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
