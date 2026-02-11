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
        Schema::create('marketing_fb', function (Blueprint $table) {
            $table->id();
            $table->date('campaing_date');
            $table->decimal('facebook_budget', 15, 2)->default(0);
            $table->integer('facebook_inbox')->default(0);
            $table->text('facebook_remark')->nullable();
            $table->timestamp('created_at')->useCurrent();
            
            $table->index('campaing_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketing_fb');
    }
};
