<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tutor Reports</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-900">

<div class="min-h-screen p-8">

    <!-- PAGE HEADER -->
    <div class="flex justify-between items-center mb-8">

        <div>

            <h1 class="text-4xl font-bold text-slate-800">
                Booking Reports
            </h1>

            <p class="text-slate-500 mt-2 text-lg">
                Manage and download your booking reports
            </p>

        </div>


        <!-- BACK BUTTON -->
        <a href="{{ route('tutor.dashboard') }}"
           class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-2xl shadow transition">

            Back Dashboard

        </a>

    </div>



    <!-- TABLE CARD -->
    <div class="bg-white border border-slate-200 rounded-3xl shadow-lg overflow-hidden">

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <!-- TABLE HEADER -->
                <thead class="bg-white border-b border-slate-200">

                    <tr>

                        <th class="px-8 py-5 text-left text-sm font-bold text-slate-700">
                            Booking ID
                        </th>

                        <th class="px-8 py-5 text-left text-sm font-bold text-slate-700">
                            Student
                        </th>

                        <th class="px-8 py-5 text-left text-sm font-bold text-slate-700">
                            Subject
                        </th>

                        <th class="px-8 py-5 text-left text-sm font-bold text-slate-700">
                            Status
                        </th>

                        <th class="px-8 py-5 text-left text-sm font-bold text-slate-700">
                            Action
                        </th>

                    </tr>

                </thead>



                <!-- TABLE BODY -->
                <tbody class="divide-y divide-slate-100">

                    @forelse($bookings as $booking)

                        <tr class="hover:bg-slate-50 transition">

                            <!-- BOOKING ID -->
                            <td class="px-8 py-6 font-semibold text-slate-800">
                                #{{ $booking->id }}
                            </td>



                            <!-- STUDENT -->
                            <td class="px-8 py-6 text-slate-600">
                                {{ $booking->student->name ?? 'N/A' }}
                            </td>



                            <!-- SUBJECT -->
                            <td class="px-8 py-6 text-slate-600">
                                {{ $booking->subject->name ?? 'N/A' }}
                            </td>



                            <!-- STATUS -->
                            <td class="px-8 py-6">

                                @if($booking->status == 'approved')

                                    <span class="bg-emerald-100 text-emerald-700 px-4 py-2 rounded-full text-sm font-semibold">

                                        Approved

                                    </span>

                                @elseif($booking->status == 'rejected')

                                    <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-semibold">

                                        Rejected

                                    </span>

                                @else

                                    <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-sm font-semibold">

                                        Pending

                                    </span>

                                @endif

                            </td>



                            <!-- ACTION -->
                            <td class="px-8 py-6">

                                <div class="flex items-center gap-3">

                                    <!-- PREVIEW -->
                                    <a href="{{ route('tutor.reports.preview', $booking->id) }}"
                                       class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl transition font-medium shadow-sm">

                                        Preview

                                    </a>


                                    <!-- DOWNLOAD -->
                                    <a href="{{ route('tutor.reports.download', $booking->id) }}"
                                       class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2 rounded-xl transition font-medium shadow-sm">

                                        Download

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5"
                                class="px-8 py-12 text-center text-slate-400 text-lg">

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