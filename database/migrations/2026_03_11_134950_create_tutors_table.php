<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Run the migrations
    public function up(): void
    {
        Schema::create('tutors', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->primary();
            $table->unsignedInteger('user_id');
            $table->string('phone');
            $table->string('address');
            $table->decimal('price_per_hour', 8, 2);
            $table->text('bio');

            $table->enum('status', ['pending', 'approved', 'rejected'])
                  ->default('pending');

            $table->text('rejection_message')->nullable();

            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    // Reverse the migrations
    public function down(): void
    {
        Schema::dropIfExists('tutors');
    }
};