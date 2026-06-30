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
    Schema::table('employees', function (Blueprint $table) {
        $table->enum('blood_group', [
            'A+', 'A-', 
            'B+', 'B-', 
            'AB+', 'AB-', 
            'O+', 'O-'
        ])->nullable()->after('phone'); // যেই column এর পরে বসাবেন
    });
}

public function down()
{
    Schema::table('employees', function (Blueprint $table) {
        $table->dropColumn('blood_group');
    });
}
};
