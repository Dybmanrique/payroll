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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('dni',8);
            $table->date('birthdate');
            $table->string('airhsp_code');
            $table->string('name');
            $table->string('last_name');
            $table->string('second_last_name');
            $table->string('start_validity');
            $table->string('end_validity');
            $table->boolean('onp');
            $table->string('bank_account');
            $table->date('date_entry');
            $table->integer('working_hours');
            $table->boolean('essalud');
            $table->string('ruc')->nullable();
            $table->enum('gender',['Masculino', 'Femenino']);
            $table->foreignId('group_id')->constrained();
            $table->foreignId('job_position_id')->constrained();
            $table->foreignId('level_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
