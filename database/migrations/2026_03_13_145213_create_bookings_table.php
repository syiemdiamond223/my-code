<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Run the migrations
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table){
            $table->unsignedInteger('id')->autoIncrement()->primary(); 
            $table->unsignedInteger('student_id'); 
            $table->unsignedInteger('tutor_id'); 
            $table->unsignedInteger('subject_id'); 
            $table->date('session_date');
            $table->integer('hours');
            $table->decimal('total_price', 8, 2);
            $table->string('status')->default('pending');
            $table->string('session_mode')->default('offline');
            $table->string('meeting_link')->nullable();

            // Payment fields
            $table->string('payment_status')->default('pending');
            $table->string('razorpay_payment_id')->nullable();
            $table->string('razorpay_order_id')->nullable();
            $table->timestamp('paid_at')->nullable();
            
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('tutor_id')->references('id')->on('tutors')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });
    }

        //Reverse the migrations
        public function down(): void
        {
            Schema::dropIfExists('bookings');
        }
};