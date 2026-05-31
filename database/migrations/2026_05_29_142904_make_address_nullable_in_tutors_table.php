<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Makes the address field in the tutors table nullable to allow tutors without an address
    public function up(): void
    {
        Schema::table('tutors', function (Blueprint $table) {

            $table->string('address')->nullable()->change();

        });
    }

    public function down(): void
    {
        Schema::table('tutors', function (Blueprint $table) {

            $table->string('address')->nullable(false)->change();

        });
    }
};