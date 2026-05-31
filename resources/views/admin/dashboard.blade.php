@extends('layouts.admin')

@section('page-title', 'Admin Dashboard')

@section('page-subtitle', 'Welcome back, Administrator')

@section('content')

<div class="space-y-8">

    <!-- STATS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- USERS -->
        <div class="bg-gradient-to-r from-indigo-400 to-violet-700 p-7 rounded-3xl shadow-xl text-white">

            <p class="text-sm font-medium opacity-90">
                Total Users
            </p>

            <h2 class="text-5xl font-extrabold mt-4">
                {{ $totalUsers }}
            </h2>

        </div>



        <!-- TUTORS -->
        <div class="bg-gradient-to-r from-emerald-400 to-teal-700 p-7 rounded-3xl shadow-xl text-white">

            <p class="text-sm font-medium opacity-90">
                Approved Tutors
            </p>

            <h2 class="text-5xl font-extrabold mt-4">
                {{ $totalTutors }}
            </h2>

        </div>



        <!-- BOOKINGS -->
        <div class="bg-gradient-to-r from-cyan-400 to-blue-700 p-7 rounded-3xl shadow-xl text-white">

            <p class="text-sm font-medium opacity-90">
                Total Bookings
            </p>

            <h2 class="text-5xl font-extrabold mt-4">
                {{ $totalBookings }}
            </h2>

        </div>

    </div>



    <!-- TODAY OVERVIEW -->
    <div>

        <h2 class="text-2xl font-bold text-slate-800 mb-5">
            Today Overview
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- RECENT REGISTERED USERS -->
            <div class="bg-white p-6 rounded-3xl shadow-md border border-slate-200">

                <h3 class="text-xl font-bold text-violet-700 mb-5">
                    Recent Registered Users (Last 7 Days)
                </h3>

                @if($todayUsers->count() > 0)

                    <div class="space-y-4">

                        @foreach($todayUsers as $user)

                            <div class="border border-slate-200 rounded-2xl p-4 hover:bg-slate-50 transition">

                                <div class="flex items-center gap-3">

                                    <!-- AVATAR -->
                                    <div class="w-11 h-11 rounded-full bg-violet-600 text-white flex items-center justify-center font-bold text-lg uppercase shadow">

                                        {{ substr($user->name ?? 'U', 0, 1) }}

                                    </div>

                                    <!-- USER INFO -->
                                    <div>

                                        <p class="font-semibold text-slate-800">
                                            {{ $user->name }}
                                        </p>

                                        <p class="text-sm text-slate-500">
                                            {{ $user->email }}
                                        </p>

                                        <p class="text-xs text-slate-400 mt-1">
                                            Joined {{ $user->created_at->diffForHumans() }}
                                        </p>

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="h-40 flex items-center justify-center text-gray-400">

                        No users registered today.

                    </div>

                @endif

            </div>



            <!-- UPCOMING SESSIONS -->
            <div class="bg-white p-6 rounded-3xl shadow-md border border-slate-200">

                <h3 class="text-xl font-bold text-emerald-700 mb-5">
                    Upcoming Sessions Today
                </h3>

                @if($todayBookings->count() > 0)

                    <div class="space-y-4">

                        @foreach($todayBookings as $booking)

                            <div class="border border-slate-200 rounded-2xl p-4 hover:bg-slate-50 transition">

                                <div class="flex items-center gap-3">

                                    <!-- AVATAR -->
                                    <div class="w-11 h-11 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-lg uppercase shadow">

                                        {{ substr($booking->student->name ?? 'S', 0, 1) }}

                                    </div>

                                    <!-- SESSION INFO -->
                                    <div>

                                        <p class="font-semibold text-slate-800">
                                            {{ $booking->student->name ?? 'Student' }}
                                        </p>

                                        <p class="text-sm text-slate-500 mt-1">
                                            with
                                            {{ $booking->tutor->user->name ?? 'Tutor' }}
                                        </p>

                                        <p class="text-sm text-orange-600 mt-1">
                                            {{ $booking->subject->name ?? 'Subject' }}
                                        </p>

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="h-40 flex items-center justify-center text-gray-400">

                        No sessions scheduled for today.

                    </div>

                @endif

            </div>

        </div>

    </div>



    <!-- SYSTEM SECTION -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">

        <!-- RECENT ACTIVITY -->
        <div class="bg-white p-6 rounded-3xl shadow-md border border-slate-200 min-h-[350px] max-h-[450px] overflow-y-auto">

            <h2 class="text-xl font-bold text-slate-800 mb-5">
                Recent Activity
            </h2>

            @if($recentBookings->count() > 0)

                <div class="space-y-4">

                    @foreach($recentBookings as $booking)

                        <div class="border border-slate-200 rounded-2xl p-4 hover:bg-slate-50 transition">

                            <div class="flex items-center gap-3">

                                <!-- AVATAR -->
                                <div class="w-11 h-11 rounded-full bg-violet-600 text-white flex items-center justify-center font-bold text-lg uppercase shadow">

                                    {{ substr($booking->student->name ?? 'S', 0, 1) }}

                                </div>

                                <!-- NAME -->
                                <div>

                                    <p class="font-semibold text-blue-600">
                                        {{ $booking->student->name ?? 'Student' }}
                                    </p>

                                    <p class="text-sm text-gray-600 mt-1">
                                        with
                                        {{ $booking->tutor->user->name ?? 'Tutor' }}
                                    </p>

                                </div>

                            </div>

                            <p class="text-sm text-gray-600 mt-3">
                                booked
                                <span class="font-medium">
                                    {{ $booking->subject->name ?? 'Subject' }}
                                </span>
                            </p>

                            <p class="text-xs text-gray-500 mt-2">
                                {{ $booking->created_at->diffForHumans() }}
                            </p>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="h-52 flex items-center justify-center text-gray-400 text-sm">

                    No recent activity available.

                </div>

            @endif

        </div>



        <!-- PENDING ACTIONS -->
        <div class="bg-white p-6 rounded-3xl shadow-md border border-slate-200 min-h-[350px] max-h-[450px] overflow-y-auto">

            <h2 class="text-xl font-bold text-slate-800 mb-5">
                Pending Actions
            </h2>

            @if($recentTutors->count() > 0)

                <div class="space-y-4">

                    @foreach($recentTutors as $tutor)

                        <div class="border border-slate-200 rounded-2xl p-4 hover:bg-slate-50 transition">

                            <div class="flex items-center gap-3">

                                <!-- AVATAR -->
                                <div class="w-11 h-11 rounded-full bg-amber-500 text-white flex items-center justify-center font-bold text-lg uppercase shadow">

                                    {{ substr($tutor->user->name ?? 'T', 0, 1) }}

                                </div>

                                <!-- TUTOR INFO -->
                                <div>

                                    <p class="font-semibold text-gray-800">
                                        {{ $tutor->user->name ?? 'Tutor' }}
                                    </p>

                                    <p class="text-sm text-amber-600 mt-1">
                                        Waiting for approval
                                    </p>

                                    <p class="text-xs text-gray-400 mt-2">
                                        {{ $tutor->created_at->diffForHumans() }}
                                    </p>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="h-52 flex items-center justify-center text-gray-400 text-sm">

                    No pending tutor approvals.

                </div>

            @endif

        </div>

    </div>

</div>

@endsection