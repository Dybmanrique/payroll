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
        Schema::create('budgetary_objectives', function (Blueprint $table) {
            $table->id();
            $table->string('pneumonic');
            $table->string('function');
            $table->string('program');
            $table->string('subprogram');
            $table->string('program_p');
            $table->string('act_proy');
            $table->string('component');
            $table->string('cas_classifier');
            $table->string('essalud_classifier');
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgetary_objectives');
    }
};
