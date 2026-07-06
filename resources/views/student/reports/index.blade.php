@extends('layouts.student')

@section('page-title', 'Booking Records')

@section('page-subtitle', 'Manage and download your booking records')

@section('content')

<div class="bg-white border border-slate-200 rounded-3xl shadow-lg overflow-hidden">

    <div class="overflow-x-auto">

        <table class="min-w-full">

            <thead class="bg-slate-50">

                <tr>

                    <th class="px-6 py-5 text-left">
                        Booking ID
                    </th>

                    <th class="px-6 py-5 text-left">
                        Tutor
                    </th>

                    <th class="px-6 py-5 text-left">
                        Subject
                    </th>

                    <th class="px-6 py-5 text-left">
                        Status
                    </th>

                    <th class="px-6 py-5 text-left">
                        Action
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($bookings as $booking)

                    <tr class="border-t hover:bg-slate-50 transition">

                        <td class="px-6 py-5">
                            #{{ $booking->id }}
                        </td>

                        <td class="px-6 py-5">
                            {{ $booking->tutor->user->name ?? 'N/A' }}
                        </td>

                        <td class="px-6 py-5">
                            {{ $booking->subject->name ?? 'N/A' }}
                        </td>

                        <td class="px-6 py-5">

                            @if($booking->status == 'approved')

<span class="...">
    Approved
</span>

@elseif($booking->status == 'completed')

<span class="...">
    Completed
</span>

@elseif($booking->status == 'cancelled')

<span class="px-4 py-2 rounded-full text-sm font-semibold bg-gray-100 text-gray-700">
    Cancelled
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

                        <td class="px-6 py-5">

                            <div class="flex gap-3">

                                <a href="{{ route('student.reports.preview', $booking->id) }}"
                                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl">

                                    Preview

                                </a>

                                <a href="{{ route('student.reports.download', $booking->id) }}"
                                   class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2 rounded-xl">

                                    Download

                                </a>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5"
                            class="px-6 py-10 text-center text-slate-400">

                            No reports available.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection