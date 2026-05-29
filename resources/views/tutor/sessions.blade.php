@extends('layouts.tutor')

@section('page-title', 'My Sessions')

@section('page-subtitle', 'View all bookings made by students')

@section('content')

<div class="min-h-screen bg-slate-50 p-6">


    <!-- VALIDATION ERRORS -->
    @if($errors->any())

        <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-xl">

            <ul class="list-disc pl-5 space-y-1">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <!-- SESSION LIST -->
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

        @forelse($sessions as $session)

            <div class="p-6 border-b border-gray-100">

                <div class="flex items-start justify-between gap-6">

                    <!-- LEFT -->
                    <div class="space-y-2 flex-1">

                        <h2 class="text-lg font-semibold text-gray-900">
                            {{ $session->student->name ?? 'Student' }}
                        </h2>

                        <p class="text-sm text-gray-600">
                            Subject:
                            <span class="font-medium">
                                {{ $session->subject->name ?? 'N/A' }}
                            </span>
                        </p>

                        <p class="text-sm text-gray-600">
                            Session Date:
                            <span class="font-medium">
                                {{ $session->session_date }}
                            </span>
                        </p>

                        <p class="text-sm text-gray-600">
                            Duration:
                            <span class="font-medium">
                                {{ $session->hours }} hour(s)
                            </span>
                        </p>

                        <p class="text-sm text-gray-600">
                            Session Mode:
                            <span class="font-medium">
                                {{ ucfirst($session->session_mode) }}
                            </span>
                        </p>

                        <!-- OFFLINE DETAILS -->
                        @if($session->session_mode == 'offline')

                            <div class="mt-5 bg-orange-50 border border-orange-200 rounded-2xl p-5">

                                <h3 class="text-lg font-bold text-orange-800 mb-4">
                                    Student Home Details
                                </h3>

                                <div class="space-y-3">

                                    <div>

                                        <p class="text-sm text-gray-500">
                                            Phone Number
                                        </p>

                                        <p class="font-medium text-gray-800">
                                            {{ $session->student_phone ?? 'Not Provided' }}
                                        </p>

                                    </div>

                                    <div>

                                        <p class="text-sm text-gray-500">
                                            Home Address
                                        </p>

                                        <p class="font-medium text-gray-800">
                                            {{ $session->student_address ?? 'Not Provided' }}
                                        </p>

                                    </div>

                                </div>

                            </div>

                        @endif

                        <!-- APPROVE / REJECT -->
                        @if($session->status == 'pending')

                            <div class="flex gap-3 pt-3">

                                <!-- APPROVE -->
                                <form method="POST"
                                      action="{{ route('tutor.booking.approve', $session->id) }}">

                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">

                                        Approve

                                    </button>

                                </form>

                                <!-- REJECT -->
                                <form method="POST"
                                      action="{{ route('tutor.booking.reject', $session->id) }}">

                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">

                                        Reject

                                    </button>

                                </form>

                            </div>

                        @endif


                        <!-- MEETING LINK SECTION -->
                        @if($session->status == 'approved' && $session->session_mode == 'online')

                            <div class="mt-5 border-t border-gray-200 pt-5">

                                <form method="POST"
                                      action="{{ route('tutor.booking.meeting', $session->id) }}"
                                      class="space-y-4">

                                    @csrf
                                    @method('PATCH')

                                    <div>

                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Meeting Link
                                        </label>

                                        <input type="url"
                                               name="meeting_link"
                                               value="{{ $session->meeting_link }}"
                                               placeholder="https://meet.google.com/..."
                                               class="w-full border border-gray-300 rounded-xl px-4 py-3 text-black bg-white focus:ring-2 focus:ring-blue-500 outline-none"
                                               required>

                                    </div>

                                    <button type="submit"
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">

                                        Save Meeting Link

                                    </button>

                                </form>


                                @if($session->meeting_link)

                                    <div class="mt-4">

                                        <a href="{{ $session->meeting_link }}"
                                           target="_blank"
                                           class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">

                                            Open Meeting Link

                                        </a>

                                    </div>

                                @endif

                            </div>

                        @endif

                    </div>

                    <!-- RIGHT STATUS -->
                    <div>

                        <span class="px-3 py-1 rounded-full text-sm font-medium

                            @if($session->status == 'pending')
                                bg-yellow-100 text-yellow-700
                            @elseif($session->status == 'completed')
                                bg-green-100 text-green-700
                            @elseif($session->status == 'rejected')
                                bg-red-100 text-red-700
                            @else
                                bg-blue-100 text-blue-700
                            @endif
                        ">

                            {{ ucfirst($session->status) }}

                        </span>

                    </div>

                </div>

            </div>

        @empty

            <!-- EMPTY STATE -->
            <div class="p-12 text-center">

                <h3 class="text-lg font-semibold text-gray-700">
                    No Sessions Yet
                </h3>

                <p class="text-gray-500 mt-2">
                    Student bookings will appear here.
                </p>

            </div>

        @endforelse

    </div>

</div>

@endsection