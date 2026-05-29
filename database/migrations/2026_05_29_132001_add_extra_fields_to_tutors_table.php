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
        Schema::table('tutors', function (Blueprint $table) {

            $table->string('mode')->nullable();

            $table->string('qualification')->nullable();

            $table->string('experience')->nullable();

            $table->string('institution')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('tutors', function (Blueprint $table) {

            $table->dropColumn([
                'mode',
                'qualification',
                'experience',
                'institution'
            ]);

        });
    }
};
