<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Creates pivot table to link tutors and subjects
    public function up(): void
    {
        Schema::create('subject_tutor', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->primary();

            $table->unsignedInteger('tutor_id');
            $table->unsignedInteger('subject_id');

            $table->unique(['tutor_id', 'subject_id']);

            $table->foreign('tutor_id')->references('id')->on('tutors')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });
    }

    //Reverse the migrations
    public function down(): void
    {
        Schema::dropIfExists('subject_tutor');
    }
};
