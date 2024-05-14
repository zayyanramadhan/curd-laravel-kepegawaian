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
        Schema::create('education', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id');
            $table->string('name', length: 255);
            $table->enum('level', ['Tk', 'Sd', 'Smp', 'Sma', 'Strata 1', 'Strata 2', 'Doktor', 'Profesor']);
            $table->boolean('is_married');
            $table->string('description', length: 255);
            $table->string('created_by', length: 255);
            $table->string('updated_by', length: 255);
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employee');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education');
    }
};
