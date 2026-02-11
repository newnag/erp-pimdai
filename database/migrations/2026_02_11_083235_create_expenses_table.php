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
        Schema::create('expenses', function (Blueprint $table) {
            $table->string('expense_no', 50)->primary();
            $table->foreignId('category_id')->constrained('expense_categories')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('expense_date');
            $table->decimal('amount', 15, 2);
            $table->text('detail')->nullable();
            $table->enum('status', ['Pending', 'Approved', 'Rejected', 'Paid'])->default('Pending');
            $table->timestamps();
            
            $table->index('category_id');
            $table->index('user_id');
            $table->index('expense_date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
