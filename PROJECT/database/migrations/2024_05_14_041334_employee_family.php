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
        Schema::create('employee_family', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id');
            $table->string('name')->nullable();
            $table->string('identifer', length: 255)->nullable();
            $table->string('job', length: 255)->nullable();
            $table->string('place_of_birth')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('religion', ['Islam', 'Katolik', 'Buda', 'Protestan', 'Konghucu']);
            $table->boolean('is_life');
            $table->boolean('is_divorced');
            $table->enum('relation_status', ['Suami', 'Istri', 'Anak', 'Anak Sambung']);
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
        Schema::dropIfExists('employee_family');
    }
};
