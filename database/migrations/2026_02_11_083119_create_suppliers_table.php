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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->enum('contact_type', ['Individual', 'Corporate'])->default('Corporate');
            $table->string('supplier_code', 50)->nullable()->index();
            $table->string('company_name');
            $table->string('tax_id', 50)->nullable();
            $table->string('contact_person')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->enum('business_add', ['ไทย', 'ต่างประเทศ'])->nullable()->default('ไทย');
            $table->integer('payment_term_days')->default(0);
            $table->enum('com_branch', ['Head', 'Branch'])->nullable()->default('Head');
            $table->string('contact_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone', 20)->nullable();
            $table->integer('product_type')->nullable();
            $table->string('bank', 100)->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_acc_no', 50)->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('link_file', 500)->nullable();
            $table->text('note')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
