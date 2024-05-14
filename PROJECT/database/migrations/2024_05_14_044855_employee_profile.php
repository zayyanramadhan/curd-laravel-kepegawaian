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
        Schema::create('employee_profile', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id');
            $table->string('place_of_birth')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['Laki-Laki', 'Perempuan']);
            $table->boolean('is_married');
            $table->string('prof_pict', length: 255)->nullable();
            $table->string('created_by', length: 255)->nullable();
            $table->string('updated_by', length: 255)->nullable();
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employee');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_profile');
    }
};
