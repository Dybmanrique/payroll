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
        Schema::create('judicial_discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('amount', 9, 2);
            $table->string('account')->nullable();
            $table->string('dni')->nullable();
            $table->enum('discount_type',['fijo', 'porcentaje_total']);
            $table->boolean('is_deleted');
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('judicial_discounts');
    }
};
