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
        Schema::table('employee_leave_requests', function (Blueprint $table) {
            $table->enum('shift', ['AM', 'PM', 'Full Day']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_leave_requests', function (Blueprint $table) {
            $table->dropColumn([
                'shift'
            ]);
        });
    }
};
