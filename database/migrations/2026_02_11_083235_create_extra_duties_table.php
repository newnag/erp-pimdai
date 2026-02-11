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
        Schema::create('extra_duties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('duty_date');
            $table->string('duty_type', 100)->nullable();
            $table->integer('recall')->default(0);
            $table->string('link_file', 500)->nullable();
            $table->timestamp('created_at')->useCurrent();
            
            $table->index('user_id');
            $table->index('duty_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extra_duties');
    }
};
