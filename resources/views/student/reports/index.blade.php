<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student Reports</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white min-h-screen text-gray-900">

<div class="p-8">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-8">

        <div>

            <h1 class="text-4xl font-bold text-slate-800">
                My Booking Reports
            </h1>

            <p class="text-slate-500 mt-2 text-lg">
                Preview and download your booking reports
            </p>

        </div>

        <a href="{{ route('student.dashboard') }}"
           class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-2xl font-semibold shadow">

            Back Dashboard

        </a>

    </div>



    <!-- TABLE -->
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

                        <tr class="border-t">

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

                                <span class="px-4 py-2 rounded-full text-sm font-semibold bg-emerald-100 text-emerald-700">

                                    {{ ucfirst($booking->status) }}

                                </span>

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

</div>

</body>
</html>