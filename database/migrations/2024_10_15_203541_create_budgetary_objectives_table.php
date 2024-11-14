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
            $table->integer('year');
            $table->string('programa_pptal');
            $table->string('producto_proyecto');
            $table->string('activ_obra_accinv');
            $table->string('funcion');
            $table->string('division_fn');
            $table->string('grupo_fn');
            $table->string('sec_func');
            $table->string('cas_classifier')->nullable();
            $table->string('essalud_classifier')->nullable();
            $table->string('aguinaldo_classifier')->nullable();
            $table->text('name');
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
