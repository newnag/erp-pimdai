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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_code', 50)->unique();
            $table->string('product_name');
            $table->foreignId('category_id')->nullable()->constrained('product_categories')->onDelete('set null');
            $table->enum('product_type', ['Service', 'Finished Goods', 'Raw Materials'])->default('Finished Goods');
            $table->text('description')->nullable();
            $table->string('unit', 50)->nullable();
            $table->decimal('cost_price', 15, 2)->default(0);
            $table->decimal('selling_price', 15, 2)->default(0);
            $table->integer('reorder_level')->default(0);
            $table->integer('current_stock')->default(0);
            $table->string('product_img', 500)->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
