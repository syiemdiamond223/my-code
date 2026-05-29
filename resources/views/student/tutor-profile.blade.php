@extends('layouts.student')

@section('content')

<div class="min-h-screen bg-gray-50 p-6">

    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

        <!-- Header -->
        <div class="bg-blue-600 p-8 text-white">

            <div class="flex items-center gap-5">

                <div class="w-20 h-20 rounded-full bg-white text-blue-600 flex items-center justify-center text-3xl font-bold">
                    {{ strtoupper(substr($tutor->user->name ?? 'T', 0, 1)) }}
                </div>

                <div>

                    <h1 class="text-3xl font-bold">
                        {{ $tutor->user->name }}
                    </h1>

                    <p class="text-blue-100 mt-1">
                        {{ $tutor->qualification ?? 'Tutor' }}
                    </p>

                </div>

            </div>

        </div>

        <!-- Content -->
        <div class="p-8 space-y-8">

            <!-- Subjects -->
            <div>

                <h2 class="text-xl font-bold text-gray-900 mb-3">
                    Subjects
                </h2>

                <div class="flex flex-wrap gap-3">

                    @forelse($tutor->subjects as $subject)

                        <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-medium">
                            {{ $subject->name }}
                        </span>

                    @empty

                        <p class="text-gray-500">
                            No subjects added.
                        </p>

                    @endforelse

                </div>

            </div>

            <!-- About -->
            <div>

                <h2 class="text-xl font-bold text-gray-900 mb-3">
                    About Tutor
                </h2>

                <p class="text-gray-700 leading-relaxed">
                    {{ $tutor->bio ?? 'No description available.' }}
                </p>

            </div>

            <!-- Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">

                    <p class="text-sm text-gray-500 mb-1">
                        Experience
                    </p>

                    <h3 class="text-lg font-semibold text-gray-900">
                        {{ $tutor->experience ?? 0 }} Years
                    </h3>

                </div>

                <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">

                    <p class="text-sm text-gray-500 mb-1">
                        Teaching Mode
                    </p>

                    <h3 class="text-lg font-semibold text-gray-900 capitalize">
                        {{ $tutor->mode ?? 'Not Set' }}
                    </h3>

                </div>

                <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">

                    <p class="text-sm text-gray-500 mb-1">
                        Institution
                    </p>

                    <h3 class="text-lg font-semibold text-gray-900">
                        {{ $tutor->institution ?? 'Not Set' }}
                    </h3>

                </div>

                <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">

                    <p class="text-sm text-gray-500 mb-1">
                        Price Per Hour
                    </p>

                    <h3 class="text-lg font-semibold text-blue-600">
                        ₹{{ $tutor->price_per_hour ?? '---' }}/hr
                    </h3>

                </div>

            </div>

            <!-- Button -->
            <div>

                <a href="{{ route('student.booking.create', $tutor->id) }}"
                    class="block text-center w-full bg-blue-600 hover:bg-blue-700 transition text-white py-4 rounded-xl font-semibold">
                        Book Session
                    </a>
            </div>

        </div>

    </div>

</div>

@endsection