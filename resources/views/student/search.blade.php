@extends('layouts.student')

@section('page-title', 'Search Tutors')

@section('page-subtitle', 'Find the perfect tutor for your learning needs')

@section('content')

<div class="p-6 space-y-6 bg-gray-50 min-h-screen">

    <!-- SEARCH BAR -->
    <div class="flex justify-center mb-3">

        <form method="GET" action="{{ route('student.search') }}" class="w-full max-w-2xl">

            <div class="flex items-center bg-white shadow-sm rounded-full overflow-hidden border border-gray-200">

                <input 
                    type="text" 
                    name="search"
                    value="{{ $query ?? '' }}"
                    placeholder="Search tutors by subject..."
                    class="w-full px-5 py-3 text-gray-900 outline-none"
                >

                <button 
                    type="submit"
                    class="bg-blue-600 text-white px-6 py-3 hover:bg-blue-700 transition font-medium">
                    Search
                </button>

            </div>

        </form>

    </div>

    <!-- RESULT COUNT -->
    @if(isset($tutors))
        <p class="text-sm text-gray-500 mb-6 text-center">
            {{ $tutors->count() }} tutor(s) found
        </p>
    @endif

    <!-- TITLE -->
    <h2 class="text-2xl font-bold text-gray-900 mb-4">
        {{ $query ? 'Search Results' : 'Available Tutors' }}
    </h2>

    <!-- TUTOR GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @forelse($tutors as $tutor)

            <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition border border-gray-200 p-6">

                <!-- HEADER -->
                <div class="flex items-center gap-4 mb-4">

                    <!-- Avatar -->
                    <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">
                        {{ strtoupper(substr($tutor->user->name ?? 'T', 0, 1)) }}
                    </div>

                    <!-- Tutor Info -->
                    <div>

                        <h3>
                            <a href="{{ route('student.tutor.show', $tutor->id) }}"
                               class="font-semibold text-gray-900 hover:text-blue-600 transition">

                                {{ $tutor->user->name }}

                            </a>
                        </h3>

                        <p class="text-sm text-gray-500">

                            @forelse($tutor->subjects as $subject)

                                {{ $subject->name }}@if(!$loop->last), @endif

                            @empty

                                Subject not set

                            @endforelse

                        </p>

                    </div>

                </div>

                <!-- DESCRIPTION -->
                <p class="text-sm text-gray-600 mb-5 line-clamp-3">
                    {{ $tutor->bio ?? 'No description available yet.' }}
                </p>

                <!-- FOOTER -->
                <div class="flex items-center justify-between">

                    <p class="font-semibold text-blue-600">
                        ₹{{ $tutor->price_per_hour ?? '---' }}/hr
                    </p>

                    <span class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full">
                        Available
                    </span>

                </div>

                <!-- ACTION -->
                <a href="{{ route('student.booking.create', $tutor->id) }}"
                   class="block text-center w-full bg-blue-600 hover:bg-blue-700 transition text-white py-3 rounded-xl font-medium">

                    Book Now

                </a>

            </div>

        @empty

            <!-- EMPTY STATE -->
            <div class="col-span-3 flex justify-center">

                <div class="text-center bg-white border border-gray-200 shadow-sm rounded-2xl p-10 max-w-md">

                    <h3 class="text-lg font-semibold text-gray-700">
                        No tutors found
                    </h3>

                    <p class="text-sm text-gray-500 mt-2">
                        Try using different keywords or subject names.
                    </p>

                </div>

            </div>

        @endforelse

    </div>

</div>

@endsection