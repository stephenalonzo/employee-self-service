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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->string('emp_name');
            $table->string('emp_id');
            $table->string('emp_department');
            $table->string('leave_type');
            $table->date('leave_start')->nullable();
            $table->date('leave_end')->nullable();
            $table->longText('leave_reason');
            $table->uuid('leave_uuid')->nullable();
            $table->timestamps();
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
