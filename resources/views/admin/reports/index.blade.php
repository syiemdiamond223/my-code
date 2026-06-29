@extends('layouts.admin')

@section('page-title', 'Booking Records')

@section('page-subtitle', 'Manage and download booking records')

@section('content')

<div class="space-y-6">

    <div class="flex justify-end">

    </div>

    <!-- REPORT TABLE -->
    <div class="bg-white border border-slate-200 rounded-3xl shadow-lg overflow-hidden">

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <!-- TABLE HEADER -->
                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-6 py-5 text-left text-sm font-bold text-slate-700">
                            Booking ID
                        </th>

                        <th class="px-6 py-5 text-left text-sm font-bold text-slate-700">
                            Student
                        </th>

                        <th class="px-6 py-5 text-left text-sm font-bold text-slate-700">
                            Tutor
                        </th>

                        <th class="px-6 py-5 text-left text-sm font-bold text-slate-700">
                            Subject
                        </th>

                        <th class="px-6 py-5 text-left text-sm font-bold text-slate-700">
                            Status
                        </th>

                        <th class="px-6 py-5 text-left text-sm font-bold text-slate-700">
                            Action
                        </th>

                    </tr>

                </thead>

                <!-- TABLE BODY -->
                <tbody class="bg-white">

                    @forelse($bookings as $booking)

                        <tr class="border-t border-slate-100 hover:bg-slate-50 transition">

                            <!-- BOOKING ID -->
                            <td class="px-6 py-5 font-semibold text-slate-800">
                                #{{ $booking->id }}
                            </td>

                            <!-- STUDENT -->
                            <td class="px-6 py-5 text-slate-600">
                                {{ $booking->student->name ?? 'N/A' }}
                            </td>

                            <!-- TUTOR -->
                            <td class="px-6 py-5 text-slate-600">
                                {{ $booking->tutor->user->name ?? 'N/A' }}
                            </td>

                            <!-- SUBJECT -->
                            <td class="px-6 py-5 text-slate-600">
                                {{ $booking->subject->name ?? 'N/A' }}
                            </td>

                            <!-- STATUS -->
                            <td class="px-6 py-5">

                                @if($booking->status == 'approved')

                                    <span class="px-4 py-2 rounded-full text-sm font-semibold bg-emerald-100 text-emerald-700">
                                        Approved
                                    </span>

                                @elseif($booking->status == 'rejected')

                                    <span class="px-4 py-2 rounded-full text-sm font-semibold bg-red-100 text-red-700">
                                        Rejected
                                    </span>

                                @else

                                    <span class="px-4 py-2 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-700">
                                        Pending
                                    </span>

                                @endif

                            </td>

                            <!-- ACTION BUTTONS -->
                            <td class="px-6 py-5">

                                <div class="flex items-center gap-3">

                                    <!-- PREVIEW -->
                                    <a href="{{ route('admin.reports.preview', $booking->id) }}"
                                       class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl transition font-medium shadow-sm">

                                        Preview

                                    </a>

                                    <!-- DOWNLOAD -->
                                    <a href="{{ route('admin.reports.download', $booking->id) }}"
                                       class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2 rounded-xl transition font-medium shadow-sm">

                                        Download

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="px-6 py-10 text-center text-slate-400 text-lg">

                                No booking reports available.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection