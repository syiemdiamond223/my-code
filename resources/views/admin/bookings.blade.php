@extends('layouts.admin')
@section('page-title', 'View Bookings')

@section('page-subtitle', 'View all bookings')

@section('content')

<div class="space-y-6">

    <div class="bg-white rounded-2xl shadow-sm p-6">

        <h2 class="text-2xl font-bold text-purple-900 mb-6">
            VIEW BOOKINGS
        </h2>

        <form method="GET"
            action="{{ route('admin.bookings') }}"
            class="bg-gray-50 p-4 rounded-xl mb-6">

            <div class="grid md:grid-cols-4 gap-4">

                <input
                    type="text"
                    name="student"
                    value="{{ request('student') }}"
                    placeholder="Search Student"
                    class="border rounded-lg px-4 py-2">

                <input
                    type="text"
                    name="tutor"
                    value="{{ request('tutor') }}"
                    placeholder="Search Tutor"
                    class="border rounded-lg px-4 py-2">

                <select
                    name="status"
                    class="border rounded-lg px-4 py-2">

                    <option value="">All Status</option>

                    <option value="pending"
                        {{ request('status') == 'pending' ? 'selected' : '' }}>
                        Pending
                    </option>

                    <option value="approved"
                        {{ request('status') == 'approved' ? 'selected' : '' }}>
                        Approved
                    </option>

                    <option value="completed"
                        {{ request('status') == 'completed' ? 'selected' : '' }}>
                        Completed
                    </option>

                    <option value="cancelled"
                        {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                        Cancelled
                    </option>

                    <option value="rejected"
                        {{ request('status') == 'rejected' ? 'selected' : '' }}>
                        Rejected
                    </option>

                </select>

                <input
                    type="text"
                    id="filterDate"
                    name="date"
                    value="{{ request('date') }}"
                    placeholder="YYYY-MM-DD"
                    class="border rounded-lg px-4 py-2">

            </div>

            <div class="mt-4 flex gap-3">

                <button type="submit"
                        class="bg-blue-600 text-white px-5 py-2 rounded-lg">

                    Filter

                </button>

                <a href="{{ route('admin.bookings') }}"
                class="bg-violet-600 text-white px-5 py-2 rounded-lg">

                    Reset

                </a>

            </div>

        </form>

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
                    </tr>
                </thead>

                <tbody>

                    @forelse($bookings as $booking)

                        <tr class="border-b hover:bg-gray-50 transition">

                            <td class="p-4 text-gray-800">
                                #{{ $booking->id }}
                            </td>

                            <td class="p-4 text-gray-800">
                                {{ $booking->student->name ?? 'N/A' }}
                            </td>

                            <td class="p-4 text-gray-800">
                                {{ $booking->tutor->user->name ?? 'N/A' }}
                            </td>

                            <td class="p-4 text-gray-800">
                                {{ $booking->subject->name ?? 'N/A' }}
                            </td>

                            <td class="p-4 text-gray-800">
                                {{ \Carbon\Carbon::parse($booking->session_date)->format('Y-m-d') }}
                            </td>

                            <td class="p-4">

                                @if($booking->status == 'completed')

                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                        Completed
                                    </span>

                                @elseif($booking->status == 'approved')

                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">
                                        Approved
                                    </span>

                                @elseif($booking->status == 'cancelled')

                                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">
                                        Cancelled
                                    </span>

                                @elseif($booking->status == 'rejected')

                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
                                        Rejected
                                    </span>

                                @else

                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">
                                        Pending
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="p-6 text-center text-gray-500">
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
