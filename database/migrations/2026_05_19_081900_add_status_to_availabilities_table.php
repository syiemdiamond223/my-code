<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Adds a status column to the availabilities table to track availability status
    public function up(): void
    {
        Schema::table('availabilities', function (Blueprint $table) {
             $table->string('status')
                  ->default('available');
        });
    }

    // Reverse the migrations.
    public function down(): void
    {
        Schema::table('availabilities', function (Blueprint $table) {
             $table->dropColumn('status');
        });
    }
};
