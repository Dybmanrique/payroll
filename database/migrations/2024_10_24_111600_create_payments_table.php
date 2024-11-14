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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('basic',9,2);
            $table->decimal('afp_discount',9,2)->nullable();
            $table->decimal('onp_discount',9,2)->nullable();
            $table->decimal('fines_discount',9,2)->nullable();
            $table->decimal('total_remuneration',9,2)->default(0);
            $table->decimal('total_discount',9,2)->default(0);
            $table->decimal('net_pay',9,2)->default(0);
            $table->decimal('essalud',9,2)->nullable();
            $table->decimal('cuarta',9,2)->nullable();
            $table->decimal('obligatory_afp',9,2)->nullable();
            $table->decimal('life_insurance_afp',9,2)->nullable();
            $table->decimal('variable_afp',9,2)->nullable();
            $table->integer('days')->default(30);
            $table->integer('days_discount')->nullable();
            $table->integer('hours_discount')->nullable();
            $table->integer('minutes_discount')->nullable();
            $table->decimal('refound', 9, 2)->nullable();
            $table->decimal('aguinaldo', 9, 2)->nullable();
            $table->foreignId('contract_id')->constrained()->onDelete('cascade');
            $table->foreignId('period_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
