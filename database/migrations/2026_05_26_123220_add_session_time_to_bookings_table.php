<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //Add session tme to bookings table to store the time of tutoring sessions
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {

            $table->time('session_time')->nullable()->after('session_date');

        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {

            $table->dropColumn('session_time');

        });
    }
};