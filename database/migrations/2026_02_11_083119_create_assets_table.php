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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_code', 50)->unique();
            $table->string('asset_name');
            $table->string('category_id', 50)->nullable();
            $table->text('detail')->nullable();
            $table->date('purchase_date')->nullable();
            $table->string('doc_ref', 100)->nullable();
            $table->decimal('quantity', 10, 2)->default(1);
            $table->string('seller_name')->nullable();
            $table->string('product_serial', 100)->nullable();
            $table->date('exp_warranty')->nullable();
            $table->text('notes')->nullable();
            $table->date('depreciation_date')->nullable();
            $table->decimal('purchase_cost', 15, 2)->default(0);
            $table->decimal('salvage_value', 15, 2)->default(0);
            $table->decimal('depreciable_amount', 15, 2)->default(0);
            $table->integer('useful_year')->default(0);
            $table->decimal('annual_depreciation_expense_percent', 5, 2)->default(0);
            $table->decimal('annual_depreciation_expense', 15, 2)->default(0);
            $table->enum('status', ['Active', 'Disposed', 'Sold'])->default('Active');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('category_id')->references('category_code')->on('asset_categories')->onDelete('set null');
            $table->index('asset_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
