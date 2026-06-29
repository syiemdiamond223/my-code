@extends('layouts.tutor')

@section('page-title', 'My Sessions')

@section('page-subtitle', 'View all bookings made by students')

@section('content')

<div>

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
    <div class="space-y-3">

        @forelse($sessions as $session)

            <div class="bg-white rounded-3xl shadow-md hover:shadow-lg transition p-6">

            <div class="flex flex-col lg:flex-row lg:justify-between gap-6">

                <!-- LEFT CONTENT -->
                <div class="flex-1">

                        <h2 class="text-xl font-semibold text-gray-900">
                            {{ $session->student->name ?? 'Student' }}
                        </h2>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                            <div>
                        <p class="text-xs uppercase text-gray-500">
                            Class
                        </p>

                        <p class="font-semibold">
                            {{ $session->student_class }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs uppercase text-gray-500">Subject</p>
                        <p class="font-semibold">{{ $session->subject->name ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <p class="text-xs uppercase text-gray-500">Date</p>
                        <p class="font-semibold">{{ $session->session_date }}</p>
                    </div>

                    <div>
                        <p class="text-xs uppercase text-gray-500">Duration</p>
                        <p class="font-semibold">{{ $session->hours }} Hour(s)</p>
                    </div>

                    <div>
                        <p class="text-xs uppercase text-gray-500">Mode</p>
                        <p class="font-semibold">{{ ucfirst($session->session_mode) }}</p>
                    </div>

                </div>

                        <!-- OFFLINE DETAILS -->
                        @if($session->session_mode == 'offline')

                           <div class="mt-5 border border-orange-200 bg-orange-50 rounded-xl p-3">

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

                               <div class="mt-5 border border-gray-200 rounded-xl p-4 bg-slate-50">
                                    <!-- SAVE MEETING LINK -->
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
                                               class="w-full rounded-xl px-4 py-3 text-black bg-white shadow-sm focus:ring-2 focus:ring-blue-500 outline-none">

                                        </div>

                                        <button type="submit"
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">

                                            Save Meeting Link

                                        </button>

                                    </form>

                                    <!-- CANCEL SESSION -->
                                    <div class="mt-3">

                                        <form method="POST"
                                            action="{{ route('tutor.booking.cancel', $session->id) }}"
                                            onsubmit="return confirm('Are you sure you want to cancel this session?')">

                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">

                                                Cancel Session

                                            </button>

                                        </form>

                                    </div>

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

            @if($session->payment_status == 'paid')

        <div class="mt-4 flex gap-3">

            <a href="{{ route('receipt.preview', $session->id) }}"
            target="_blank"
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">

                View Receipt

            </a>

            <a href="{{ route('receipt.download', $session->id) }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">

                Download Receipt

            </a>

        </div>

        @endif

        </div> <!-- CLOSE LEFT CONTENT -->

        <!-- RIGHT STATUS -->
        <div class="flex-shrink-0">

            <span class="px-4 py-2 rounded-full text-sm font-semibold

                    @if($session->status == 'pending')
                        bg-yellow-100 text-yellow-700

                    @elseif($session->status == 'approved')
                        bg-blue-100 text-blue-700

                    @elseif($session->status == 'completed')
                        bg-green-100 text-green-700

                    @elseif($session->status == 'cancelled')
                        bg-gray-100 text-gray-700

                    @elseif($session->status == 'rejected')
                        bg-red-100 text-red-700

                    @endif
                ">

                            {{ ucfirst($session->status) }}

                        </span>

                    </div>

                </div>

            </div>

        @empty

            <!-- EMPTY STATE -->
            <div class="bg-white rounded-3xl shadow-md p-12 text-center">

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