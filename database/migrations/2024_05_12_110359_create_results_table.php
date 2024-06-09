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
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->string('ic');
            $table->foreign('ic')->references('ic')->on('students')->onDelete('cascade');
            $table->integer('marks_d');
            $table->integer('marks_a');
            $table->integer('marks_s');
            $table->integer('status');
            $table->integer('assessment_round');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
