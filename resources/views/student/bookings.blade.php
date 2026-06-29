@extends('layouts.student')

@section('page-title', 'My Learning Sessions')

@section('page-subtitle', 'Track and manage your booked tutoring sessions')

@section('content')

<div class="p-4 bg-gray-50 min-h-screen">


    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 bg-green-100 text-green-700 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Message -->
    @if(session('error'))
        <div class="mb-6 bg-red-100 text-red-700 px-4 py-3 rounded-xl">
            {{ session('error') }}
        </div>
    @endif

    @if($bookings->isEmpty())

        <!-- Empty State -->
        <div class="bg-white border border-gray-200 shadow-sm rounded-2xl p-10 text-center">

            <h3 class="text-xl font-semibold text-gray-700">
                No bookings found
            </h3>

            <p class="text-gray-500 mt-2">
                Your booked sessions will appear here.
            </p>

        </div>

    @else

        <div class="space-y-4">

            @foreach($bookings as $booking)

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-200 hover:shadow-lg transition">

                <!-- Top -->
                <div class="flex justify-between items-center mb-4">

                    <div>

                        <h2 class="text-xl font-semibold text-gray-900">
                            {{ $booking->tutor->user->name }}
                        </h2>

                        <p class="text-sm text-gray-500">
                            {{ $booking->subject->name }}
                        </p>

                    </div>

                    <!-- Status -->
                    <span class="px-3 py-1 rounded-full text-sm font-medium

                        @if($booking->status == 'pending')
                            bg-yellow-100 text-yellow-700

                        @elseif($booking->status == 'approved')
                            bg-green-100 text-green-700


                        @elseif($booking->status == 'completed')
                            bg-green-100 text-green-700

                        @elseif($booking->status == 'cancelled')
                            bg-gray-200 text-gray-700

                        @elseif($booking->status == 'rejected')
                            bg-red-100 text-red-700

                        @else
                            bg-gray-100 text-gray-700
                        @endif
                    ">

                        {{ ucfirst($booking->status) }}

                    </span>

                </div>

                <!-- Booking Details -->
                <div class="space-y-1 text-sm text-gray-600 mb-3">

                    <p>
                        <strong>Date:</strong>
                        {{ $booking->session_date }}
                    </p>

                    <p>
                        <strong>Hours:</strong>
                        {{ $booking->hours }}
                    </p>

                    <p>
                        <strong>Mode:</strong>
                        {{ ucfirst($booking->session_mode) }}
                    </p>

                    <p>
                        <strong>Total Price:</strong>
                        ₹{{ $booking->total_price }}
                    </p>

                    @if($booking->payment_status == 'pending' &&
                        $booking->status != 'cancelled' &&
                        $booking->status != 'rejected')

                        <div class="mt-4">
                            <a href="{{ route('student.payment.pay', $booking->id) }}"
                            class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-5 py-2.5 rounded-xl shadow-md hover:shadow-lg transition duration-300 font-semibold">

                                💳 <span>Proceed to Payment</span>

                            </a>
                        </div>
                    @endif

                </div>

                <!-- BLOCKED  TUTOR MESSAGE -->
                @if($booking->tutor->user->status == 'blocked')

                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">

                        This tutor is currently unavailable.

                    </div>

                @endif


                <!-- OFFLINE SESSION DETAILS -->
                @if(
                    $booking->session_mode == 'offline'
                    && $booking->status != 'cancelled'
                )

                    <div class="mb-5 bg-orange-50 border border-orange-200 rounded-xl p-4">

                        <h3 class="font-semibold text-orange-700 mb-3">
                            Home Tuition Details
                        </h3>

                        <p class="text-sm text-gray-700 mb-2">
                            <strong>Phone:</strong>
                            {{ $booking->student_phone }}
                        </p>

                        <p class="text-sm text-gray-700">
                            <strong>Address:</strong>
                            {{ $booking->student_address }}
                        </p>

                    </div>

                @endif


                <!-- ONLINE MEETING LINK -->
                @if(
                    $booking->session_mode == 'online'
                    && $booking->meeting_link
                    && $booking->status == 'approved'
                    && $booking->tutor->user->status == 'active'
                )

                    <div class="mb-4">

                        <a href="{{ $booking->meeting_link }}"
                           target="_blank"
                           class="inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">

                            Join Meeting

                        </a>

                    </div>

                @endif


                <!-- WAITING MESSAGE -->
                @if(
                    $booking->session_mode == 'online'
                    && !$booking->meeting_link
                    && $booking->status == 'approved'
                    && $booking->tutor->user->status == 'active'
                )

                    <div class="mb-4 bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-xl text-sm">

                        Tutor has approved the booking.
                        Waiting for meeting link.

                    </div>

                @endif


                <!-- CANCELLED MESSAGE -->
                @if($booking->refund_status != 'not_requested')

                <div class="mt-3 bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-xl text-sm">

                    Refund Status:
                    {{ ucfirst(str_replace('_', ' ', $booking->refund_status)) }}

                    <br>

                    Refund Amount:
                    ₹{{ $booking->refund_amount }}

                </div>

                @endif

                @if($booking->status == 'cancelled')

                    <div class="bg-gray-100 text-gray-700 px-4 py-3 rounded-xl text-sm">

                        This booking has been cancelled.

                    </div>

                @endif

                @if($booking->status == 'completed')

                    <div class="bg-green-50 text-green-700 border border-green-200 px-4 py-3 rounded-xl text-sm">

                        This tutoring session has been completed.

                    </div>

                @endif

                <!-- REJECTED MESSAGE -->
                @if($booking->status == 'rejected')

                    <div class="bg-red-50 text-red-700 border border-red-200 px-4 py-3 rounded-xl text-sm">

                        Tutor rejected this booking request.

                    </div>

                @endif


                <!-- CANCEL BUTTON -->
                @if(
                    $booking->status != 'completed'
                    && $booking->status != 'cancelled'
                    && $booking->status != 'rejected'
                )

                    <form method="POST"
                          action="{{ route('student.bookings.cancel', $booking->id) }}"
                          onsubmit="return confirm('Are you sure you want to cancel this booking?')">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">

                            Cancel Session

                        </button>

                    </form>

                @endif

            </div>

            @endforeach

        </div>

    @endif

</div>

@endsection