<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Stores all system users
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {

            $table->unsignedInteger('id')->autoIncrement()->primary();

            $table->string('name');//name of the user

            $table->string('email')->unique();

            $table->string('role');

            $table->string('status')->default('active');

            $table->string('password');

            $table->rememberToken();

            $table->timestamps();
        });
    }

    // Reverse the migrations
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};