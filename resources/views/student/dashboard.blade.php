@extends('layouts.student')

@section('page-title', 'Student Dashboard')

@section('page-subtitle', 'Welcome to your dashboard! Explore tutors, manage bookings, and track your learning journey.')

@section('content')

<div class="p-6 space-y-10 bg-gray-50 min-h-screen">

    {{-- HERO SECTION --}}
    <div class="relative overflow-hidden rounded-3xl shadow-lg border border-blue-100 min-h-[340px]">

        <img src="{{ asset('images/student_dashboard.jpeg') }}"
             alt="Student Dashboard"
             class="absolute inset-0 w-full h-full object-cover">

        <div class="absolute inset-0 bg-white/10"></div>

        <div class="relative z-10 flex items-center h-full px-10 py-10">

            <div class="w-28 h-28 rounded-full bg-blue-600 flex items-center justify-center text-white text-5xl font-bold shadow-xl">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>

            <div class="ml-8">

                <h1 class="text-5xl font-bold text-gray-900">
                    Welcome, {{ Auth::user()->name }}
                </h1>

                <p class="text-lg text-gray-700 mt-3 max-w-2xl">
                    Discover tutors, book sessions, and start learning smarter.
                </p>

            </div>

        </div>

    </div>



    {{-- QUICK STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <p class="text-gray-500 text-sm font-medium">Booked Sessions</p>
            <h2 class="text-4xl font-bold text-blue-600 mt-3">
                {{ $bookedSessions ?? 0 }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <p class="text-gray-500 text-sm font-medium">Available Tutors</p>
            <h2 class="text-4xl font-bold text-indigo-600 mt-3">
                {{ isset($tutors) ? $tutors->count() : 0 }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <p class="text-gray-500 text-sm font-medium">Learning Hours</p>
            <h2 class="text-4xl font-bold text-purple-600 mt-3">
                {{ $learningHours ?? 0 }}h
            </h2>
        </div>

    </div>



    {{-- SECTION TITLE --}}
    <div>
        <h2 class="text-3xl font-bold text-gray-900">
            Recommended Tutors
        </h2>

        <p class="text-gray-500 mt-2">
            Find the best tutors for your learning needs.
        </p>
    </div>



    {{-- TUTOR GRID --}}
    @if(isset($tutors) && $tutors->count() > 0)

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach($tutors as $tutor)

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 hover:shadow-xl hover:-translate-y-1 transition duration-300">

            {{-- HEADER --}}
            <div class="flex items-center space-x-4 mb-5">

                <div class="w-16 h-16 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-xl shadow-md">
                    {{ strtoupper(substr($tutor->user->name ?? 'T', 0, 1)) }}
                </div>

                <div>

                    <h3 class="font-bold text-lg text-gray-900">
                        <a href="{{ route('student.tutor.show', $tutor->id) }}"
                           class="hover:text-blue-600 transition">

                            {{ $tutor->user->name ?? 'Tutor Name' }}

                        </a>
                    </h3>

                    <p class="text-sm text-gray-500">
                        @forelse($tutor->subjects ?? [] as $subject)
                            {{ $subject->name }}@if(!$loop->last), @endif
                        @empty
                            Subject not set
                        @endforelse
                    </p>

                </div>

            </div>



            {{-- BIO --}}
            <div class="mb-5">
                <p class="text-gray-600 leading-relaxed">
                    {{ \Illuminate\Support\Str::limit($tutor->bio ?? 'No bio available.', 120) }}
                </p>
            </div>



            {{-- PRICE + STATUS --}}
            <div class="flex items-center justify-between mb-4">

                <p class="font-bold text-blue-600 text-2xl">
                    ₹{{ $tutor->price_per_hour ?? '---' }}/hr
                </p>

                <span class="bg-green-100 text-green-700 text-sm px-4 py-1 rounded-full">
                    Available
                </span>

            </div>



            {{-- AVAILABLE SLOTS --}}
            @if(!empty($tutor->availabilities) && $tutor->availabilities->count())

                <div class="mt-4">

                    <h4 class="font-semibold text-gray-800 mb-3">
                        Available Slots
                    </h4>

                    @foreach($tutor->availabilities as $slot)

                        <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-3">

                            <p class="text-gray-700">
                                Date: {{ $slot->available_date }}
                            </p>

                            <p class="text-green-700 font-semibold">
                                Time:
                                {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}
                                -
                                {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                            </p>

                        </div>

                    @endforeach

                </div>

            @endif



            {{-- BUTTON --}}
            <div class="mt-5">

                <a href="{{ route('student.booking.create', $tutor->id) }}"
                   class="block w-full text-center bg-blue-600 text-white py-3 rounded-2xl font-semibold hover:bg-blue-700 transition">

                    Book Now

                </a>

            </div>

        </div>

        @endforeach

    </div>

    @else

    <div class="bg-white p-12 rounded-2xl shadow-sm border border-gray-200 text-center">
        <p class="text-gray-700 text-xl font-semibold">
            No tutors available right now.
        </p>
        <p class="text-sm text-gray-400 mt-3">
            Once tutors register, they will appear here automatically.
        </p>
    </div>

    @endif

</div>

@endsection