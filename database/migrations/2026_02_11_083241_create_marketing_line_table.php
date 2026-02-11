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
        Schema::create('marketing_line', function (Blueprint $table) {
            $table->id();
            $table->date('campaing_date');
            $table->decimal('line_budget', 15, 2)->default(0);
            $table->integer('line_follow')->default(0);
            $table->integer('line_click')->default(0);
            $table->integer('line_actual')->default(0);
            $table->text('line_remark')->nullable();
            $table->timestamp('created_at')->useCurrent();
            
            $table->index('campaing_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketing_line');
    }
};
