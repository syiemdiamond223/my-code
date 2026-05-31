@extends('layouts.tutor')

@section('page-title', 'Tutor Dashboard')

@section('page-subtitle', 'Welcome to your dashboard, manage your sessions and bookings')

@section('content')

<div class="space-y-6">

    {{-- WELCOME SECTION --}}
    <div class="relative overflow-hidden rounded-3xl shadow-sm border border-blue-100 min-h-[340px] mb-10">

        {{-- Background Image --}}
        <img src="{{ asset('images/tutors_dashboard.jpeg') }}"
             class="absolute inset-0 w-full h-full object-cover object-center opacity-90">

        {{-- Overlay --}}
        <div class="absolute inset-0 bg-white/20 backdrop-blur-[1px]"></div>

        {{-- Content --}}
        <div class="relative z-10 p-8 md:p-10 flex items-center gap-6">

            {{-- Avatar --}}
            <div class="w-28 h-28 rounded-full bg-blue-500 flex items-center justify-center text-white text-5xl font-bold shadow-lg">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>

            {{-- TEXT --}}
            <div>
                <h1 class="text-4xl font-bold text-gray-900">
                    Welcome, {{ Auth::user()->name }}
                </h1>

                <p class="text-gray-600 mt-2 text-lg">
                    Manage your tutoring activities and stay connected with students.
                </p>
            </div>

        </div>
    </div>



    {{-- STATS --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">

    {{-- TOTAL STUDENTS --}}
    <div class="bg-gradient-to-br from-rose-400 to-violet-700 rounded-3xl p-6 shadow-lg text-white">

        <p class="text-white text-sm">
            Total Students
        </p>

        <h2 class="text-4xl font-bold mt-3">
            {{ $totalStudents ?? 0 }}
        </h2>

    </div>


    {{-- UPCOMING SESSIONS --}}
    <div class="bg-gradient-to-br from-violet-400 to-blue-700 rounded-3xl p-6 shadow-lg text-white">

        <p class="text-white text-sm">
            Upcoming Sessions
        </p>

        <h2 class="text-4xl font-bold mt-3">
            {{ $upcomingSessionList->count() ?? 0 }}
        </h2>

    </div>


    {{-- PENDING REQUESTS --}}
    <div class="bg-gradient-to-br from-amber-400 to-violet-600 rounded-3xl p-6 shadow-lg text-white">

        <p class="text-white text-sm">
            Pending Requests
        </p>

        <h2 class="text-4xl font-bold mt-3">
            {{ $pendingBookings->count() ?? 0 }}
        </h2>

    </div>


    {{-- PROFILE STATUS --}}
    @php
        $tutorProfile = auth()->user()->tutor;
    @endphp

    {{-- PROFILE STATUS --}}
    <div class="rounded-3xl p-6 shadow-lg text-white

        @if(!$tutorProfile)
            bg-gradient-to-br from-slate-500 to-slate-700

        @elseif($tutorProfile->status == 'approved')
            bg-gradient-to-br from-green-400 to-green-700

        @elseif($tutorProfile->status == 'pending')
            bg-gradient-to-br from-yellow-400 to-yellow-700

        @else
            bg-gradient-to-br from-red-400 to-red-700
        @endif
        ">

        <p class="text-sm opacity-90">
            Profile Status
        </p>

        <h2 class="text-3xl font-bold mt-3">

            @if(!$tutorProfile)
                Incomplete
            @else
                {{ ucfirst($tutorProfile->status) }}
            @endif

        </h2>

        @if(!$tutorProfile)

            <p class="mt-3 text-sm opacity-90">
                Please complete your tutor profile.
            </p>

        @elseif($tutorProfile->status == 'rejected')

            <p class="mt-3 text-sm opacity-90">
                {{ $tutorProfile->rejection_message }}
            </p>

        @endif

    </div>

    </div>


    {{-- QUICK ACTION --}}
    <div class="bg-white rounded-2xl border border-blue-100 p-6 shadow-sm flex items-center justify-between">

        <div>
            <h3 class="text-lg font-semibold text-gray-800">
                Quick Actions
            </h3>
            <p class="text-sm text-gray-500">
                Manage your availability and sessions easily
            </p>
        </div>

        <a href="{{ route('tutor.availability') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold shadow-md transition">
            Manage Availability
        </a>

    </div>



    {{-- PENDING BOOKINGS --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">

        <h2 class="text-2xl font-bold text-gray-800 mb-6">Pending Booking Requests</h2>

        @if($pendingBookings->count() > 0)

            <div class="space-y-4">

                @foreach($pendingBookings as $booking)
                    <div class="border border-gray-100 rounded-xl p-5">

                        <div class="flex justify-between">

                            <div>
                                <h3 class="font-semibold text-lg text-blue-700">{{ $booking->student->name ?? 'Student' }}</h3>
                                <p class="text-sm text-gray-700">{{ $booking->subject->name ?? 'Subject' }}</p>
                            </div>

                            <div class="flex gap-3">

                                <form method="POST" action="{{ route('tutor.booking.approve', $booking->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="bg-green-500 text-white px-5 py-2 rounded-lg">Approve</button>
                                </form>

                                <form method="POST" action="{{ route('tutor.booking.reject', $booking->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="bg-red-500 text-white px-5 py-2 rounded-lg">Reject</button>
                                </form>

                            </div>

                        </div>

                    </div>
                @endforeach

            </div>

        @else
            <p class="text-center text-gray-500 py-6">No Pending Requests</p>
        @endif

    </div>



    {{-- UPCOMING SESSIONS --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">

        <h2 class="text-2xl font-bold text-gray-800 mb-6">Upcoming Sessions</h2>

        @if($upcomingSessionList->count() > 0)

            <div class="space-y-4">

                @foreach($upcomingSessionList as $session)
                    <div class="border p-5 rounded-xl flex justify-between">

                        <div>
                            <h3 class="font-semibold text-blue-700">{{ $session->student->name ?? 'Student' }}</h3>
                            <p class="text-sm text-gray-700">{{ $session->subject->name ?? 'Subject' }}</p>
                        </div>

                        <div class="text-right">
                            <p class="font-semibold text-green-700">{{ \Carbon\Carbon::parse($session->session_date)->format('d M Y') }}</p>
                            <p class="text-sm text-gray-700">{{ \Carbon\Carbon::parse($session->session_time)->format('h:i A') }}</p>
                        </div>

                    </div>
                @endforeach

            </div>

        @else
            <p class="text-center text-gray-500 py-6">No Upcoming Sessions</p>
        @endif

    </div>



    {{-- RECENT SESSIONS --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">

        <h2 class="text-2xl font-bold text-gray-800 mb-6">Recent Sessions</h2>

        @if($recentSessions->count() > 0)

            <div class="space-y-4">

                @foreach($recentSessions as $session)

                    <div class="border p-5 rounded-xl flex justify-between">

                        <div>
                            <h3 class="font-semibold text-blue-700">{{ $session->student->name ?? 'Student' }}</h3>
                            <p class="text-sm text-gray-700">{{ $session->subject->name ?? 'Subject' }}</p>
                        </div>

                        <span class="px-4 py-2 rounded-full text-sm font-medium
                            @if($session->status == 'approved')
                                bg-green-100 text-green-700
                            @elseif($session->status == 'pending')
                                bg-yellow-100 text-yellow-700
                            @else
                                bg-red-100 text-red-700
                            @endif
                        ">
                            {{ ucfirst($session->status) }}
                        </span>

                    </div>

                @endforeach

            </div>

        @else
            <p class="text-center text-gray-500 py-6">No Recent Sessions</p>
        @endif

    </div>

</div>

@endsection