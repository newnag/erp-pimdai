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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Laravel default name field
            $table->string('username', 100)->unique()->nullable(); // Optional username for login
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable(); // Laravel email verification
            $table->string('password');
            $table->rememberToken(); // Laravel "Remember Me" functionality
            $table->string('phone', 20)->nullable();
            $table->enum('role', ['Admin', 'Sales', 'Inventory', 'Purchase', 'Accountant', 'Marketing'])->default('Sales');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
