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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->enum('contact_type', ['Individual', 'Corporate'])->default('Individual');
            $table->enum('customer_type', ['Customer', 'Vendor'])->default('Customer');
            $table->decimal('credit_limit', 15, 2)->default(0);
            $table->string('contact_id', 50)->nullable();
            $table->string('company_name')->nullable();
            $table->string('tax_id', 50)->nullable()->index();
            $table->enum('com_branch', ['Head', 'Branch'])->nullable()->default('Head');
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->text('address')->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->text('delivery_note')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone', 20)->nullable();
            $table->string('bank', 100)->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_acc_no', 50)->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('link_file', 500)->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
