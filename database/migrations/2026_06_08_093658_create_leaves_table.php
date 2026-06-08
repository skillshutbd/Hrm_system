<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('leaves', function (Blueprint $table) {
        $table->id();
        $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
        $table->foreignId('leave_type_id')->constrained('leave_types')->onDelete('cascade');
        $table->date('from_date');
        $table->date('to_date');
        $table->integer('duration');
        $table->text('reason');
        $table->string('attachment')->nullable();
        $table->boolean('is_showcase')->default(false);
        $table->enum('tl_status', ['pending', 'recommended', 'not_recommended'])->default('pending');
        $table->text('tl_note')->nullable();
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        $table->text('hr_note')->nullable();
        $table->timestamps();
        $table->softDeletes();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
