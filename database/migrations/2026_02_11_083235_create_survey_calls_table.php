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
        Schema::create('survey_calls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('survey_date');
            $table->time('survey_time')->nullable();
            $table->string('qt_no', 50)->nullable();
            $table->enum('status_call', ['รับสาย', 'ไม่รับสาย', 'เบอร์ผิด']);
            $table->enum('feedback', ['ปิดบิลใหม่', 'สนใจ/รอพิจารณา', 'ไม่สนใจ', 'เลื่อนการตัดสินใจ', 'ความคิดเห็นเชิงลบ'])->nullable();
            $table->date('follow_date')->nullable();
            $table->text('remark')->nullable();
            $table->timestamp('created_at')->useCurrent();
            
            $table->index('customer_id');
            $table->index('user_id');
            $table->index('survey_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_calls');
    }
};
