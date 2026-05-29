@extends('layouts.admin')
@section('page-title', 'View Bookings')

@section('page-subtitle', 'View all bookings')

@section('content')

<div class="space-y-6">

    <div class="bg-white rounded-2xl shadow-sm p-6">

        <h2 class="text-2xl font-bold text-purple-900 mb-6">
            View Bookings
        </h2>

        <div class="overflow-x-auto">

            <table class="w-full border-collapse">

                <thead>
                    <tr class="bg-purple-100 text-gray-800 text-left">
                        <th class="p-4 font-semibold">Booking ID</th>
                        <th class="p-4 font-semibold">Student</th>
                        <th class="p-4 font-semibold">Tutor</th>
                        <th class="p-4 font-semibold">Subject</th>
                        <th class="p-4 font-semibold">Session Date</th>
                        <th class="p-4 font-semibold">Status</th>
                        <!-- <th class="p-4 font-semibold">Payment</th> -->
                    </tr>
                </thead>

                <tbody>

                    @forelse($bookings as $booking)

                        <tr class="border-b hover:bg-gray-50 transition">

                            <!-- BOOKING ID -->
                            <td class="p-4 text-gray-800">
                                #{{ $booking->id }}
                            </td>

                            <!-- STUDENT -->
                            <td class="p-4 text-gray-800">
                                {{ $booking->student->name ?? 'N/A' }}
                            </td>

                            <!-- TUTOR -->
                            <td class="p-4 text-gray-800">
                                {{ $booking->tutor->user->name ?? 'N/A' }}
                            </td>

                            <!-- SUBJECT -->
                            <td class="p-4 text-gray-800">
                                {{ $booking->subject->name ?? 'N/A' }}
                            </td>

                            <!-- SESSION DATE -->
                            <td class="p-4 text-gray-800">
                                {{ $booking->session_date }}
                            </td>

                            <!-- STATUS -->
                            <td class="p-4">

                                @if($booking->status == 'completed')

                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                        Completed
                                    </span>

                                @elseif($booking->status == 'cancelled')

                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
                                        Cancelled
                                    </span>

                                @else

                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">
                                        Pending
                                    </span>

                                @endif

                            </td>

                            <!-- PAYMENT 
                            <td class="p-4">

                                @if($booking->payment_status == 'paid')

                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                        Paid
                                    </span>

                                @else

                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
                                        Unpaid
                                    </span>-->

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="p-6 text-center text-gray-500">
                                No bookings found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection