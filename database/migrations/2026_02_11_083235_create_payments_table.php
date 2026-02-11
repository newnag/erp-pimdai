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
        Schema::create('payments', function (Blueprint $table) {
            $table->string('payment_no', 50)->primary();
            $table->string('invoice_no', 50);
            $table->date('payment_date');
            $table->decimal('amount', 15, 2);
            $table->enum('payment_method', ['Cash', 'Transfer', 'Cheque', 'Credit'])->default('Transfer');
            $table->string('reference_no', 100)->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('created_at')->useCurrent();
            
            $table->foreign('invoice_no')->references('invoice_no')->on('invoices')->onDelete('cascade');
            $table->index('invoice_no');
            $table->index('payment_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
