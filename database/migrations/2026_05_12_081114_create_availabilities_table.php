<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('availabilities', function (Blueprint $table) {

            $table->unsignedInteger('id')->autoIncrement()->primary();

            $table->unsignedInteger('tutor_id');

            $table->date('available_date');

            $table->time('start_time');

            $table->time('end_time');

            $table->timestamps();

            $table->foreign('tutor_id')
                  ->references('id')
                  ->on('tutors')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('availabilities');
    }
};