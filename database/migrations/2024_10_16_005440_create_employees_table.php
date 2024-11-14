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
            $table->string('identity_number');
            $table->date('birthdate');
            $table->string('airhsp_code')->nullable();
            $table->string('name');
            $table->string('last_name');
            $table->string('second_last_name');
            $table->string('bank_account');
            $table->date('date_entry');
            $table->enum('pension_system', ['afp', 'onp']);
            $table->boolean('cuarta');
            $table->string('ruc')->nullable();
            $table->enum('gender', ['Masculino', 'Femenino']);
            $table->string('afp_code')->nullable();
            $table->string('afp_fing')->nullable();
            $table->foreignId('afp_id')->nullable()->constrained();
            $table->foreignId('identity_type_id')->constrained();
            $table->foreignId('group_id')->constrained();
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
