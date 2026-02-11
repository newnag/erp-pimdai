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
        Schema::create('withholding_taxes', function (Blueprint $table) {
            $table->id();
            $table->string('wht_no', 50);
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->date('payment_date');
            $table->string('tax_id', 50)->nullable();
            $table->string('branch', 100)->nullable();
            $table->text('address')->nullable();
            $table->enum('tax_type', ['Service', 'Rent', 'Professional']);
            $table->decimal('payment_amount', 15, 2);
            $table->decimal('tax_rate', 5, 2);
            $table->decimal('tax_amount', 15, 2);
            $table->text('remark')->nullable();
            $table->timestamps();
            
            $table->index('customer_id');
            $table->index('wht_no');
            $table->index('payment_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withholding_taxes');
    }
};
