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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->decimal('remuneration',9,2);
            $table->date('start_validity');
            $table->date('end_validity');
            $table->integer('working_hours');
            $table->foreignId('employee_id')->constrained();
            $table->foreignId('job_position_id')->constrained();
            $table->foreignId('level_id')->constrained();
            $table->foreignId('budgetary_objective_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
