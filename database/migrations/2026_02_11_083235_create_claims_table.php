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
        Schema::create('claims', function (Blueprint $table) {
            $table->id();
            $table->date('claim_date');
            $table->integer('inkjet_claim')->default(0);
            $table->integer('digital_claim')->default(0);
            $table->integer('accessory_claim')->default(0);
            $table->text('remark')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('claim_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claims');
    }
};
