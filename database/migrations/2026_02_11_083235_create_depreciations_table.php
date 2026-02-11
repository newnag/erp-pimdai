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
        Schema::create('depreciations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            $table->date('begin_year');
            $table->date('end_year');
            $table->integer('asset_amount')->default(0);
            $table->decimal('total_asset_amount', 15, 2)->default(0);
            $table->decimal('depreciation', 15, 2)->default(0);
            $table->text('remark')->nullable();
            $table->timestamps();
            
            $table->index('asset_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('depreciations');
    }
};
