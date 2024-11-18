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
        Schema::create('judicial_discount_payment', function (Blueprint $table) {
            $table->foreignId('judicial_discount_id')->constrained()->onDelete('cascade');
            $table->foreignId('payment_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 9, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('judicial_discount_payment');
    }
};
