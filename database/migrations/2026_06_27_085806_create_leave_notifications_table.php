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
    Schema::create('leave_notifications', function (Blueprint $table) {
        $table->id();

        $table->foreignId('leave_id')
              ->constrained('leaves')->cascadeOnDelete();

        // কাকে notification যাচ্ছে
        $table->string('recipient_type');
        // employee / tl / hr

        $table->unsignedBigInteger('recipient_id');
        // সেই role এর id

        $table->string('type');
        // leave_submitted / tl_recommended / tl_not_recommended
        // hr_approved / hr_rejected

        $table->string('message');

        $table->timestamp('read_at')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_notifications');
    }
};
