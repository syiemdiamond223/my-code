@extends('layouts.tutor')
@section('page-title', 'Set Availability')

@section('page-subtitle', 'Add your available tutoring slots for students to book sessions.')

@section('content')

<div class="min-h-screen bg-slate-50 p-6">

   
    <!-- Validation Errors -->
    @if($errors->any())

        <div class="mb-4 bg-red-100 text-red-700 px-4 py-3 rounded-xl">

            <ul class="list-disc pl-5">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <!-- Add Availability Form -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-8">

        <form method="POST"
              action="{{ route('tutor.availability.store') }}"
              class="grid grid-cols-1 md:grid-cols-4 gap-4">

            @csrf

            <!-- Date -->
            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Date
                </label>

                <input type="date"
                       id="availableDate"
                       name="available_date"
                       min="{{ date('Y-m-d') }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 text-black bg-white focus:ring-2 focus:ring-blue-500 outline-none"
                       required>

            </div>

            <!-- Start Time -->
            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Start Time
                </label>

                <input type="time"
                       name="start_time"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 text-black bg-white focus:ring-2 focus:ring-blue-500 outline-none"
                       required>

            </div>

            <!-- End Time -->
            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    End Time
                </label>

                <input type="time"
                       name="end_time"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 text-black bg-white focus:ring-2 focus:ring-blue-500 outline-none"
                       required>

            </div>

            <!-- Button -->
            <div class="flex items-end">

                <button type="submit"
                        class="w-full bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-700 transition">

                    Add Slot

                </button>

            </div>

        </form>

    </div>

    <!-- Availability List -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">

        <h2 class="text-xl font-semibold text-gray-900 mb-4">
            Your Availability
        </h2>

        @if($availabilities->count() > 0)

            <div class="space-y-4">

                <!--show each availability slot with toggle and delete options -->
                @foreach($availabilities as $availability)

                    <div class="border border-gray-200 rounded-xl p-4 flex justify-between items-center">

                        <!-- LEFT -->
                        <div>

                            <p class="font-semibold text-gray-900">
                                {{ \Carbon\Carbon::parse($availability->available_date)->format('d M Y') }}
                            </p>

                            <p class="text-gray-600 text-sm mt-1">
                                {{ \Carbon\Carbon::parse($availability->start_time)->format('h:i A') }}
                                -
                                {{ \Carbon\Carbon::parse($availability->end_time)->format('h:i A') }}
                            </p>

                        </div>

                        <!-- RIGHT -->
                        <div class="flex items-center gap-3">

                            <!-- STATUS -->
                            @if($availability->status == 'available')

                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">
                                    Available
                                </span>

                            @else

                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-medium">
                                    Unavailable
                                </span>

                            @endif

                            <!-- TOGGLE BUTTON  mark slot as available or unavailable -->
                            <form method="POST"
                                  action="{{ route('tutor.availability.toggle', $availability->id) }}">

                                @csrf
                                @method('PATCH')

                                @if($availability->status == 'available')

                                    <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">

                                        Set Unavailable

                                    </button>

                                @else

                                    <button type="submit"
                                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">

                                        Set Available

                                    </button>

                                @endif

                            </form>

                            <!-- DELETE BUTTON -->
                            <form method="POST"
                                action="{{ route('tutor.availability.delete', $availability->id) }}">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        onclick="return confirm('Delete this availability slot?')"
                                        class="bg-gray-700 hover:bg-black text-white px-4 py-2 rounded-lg text-sm font-medium transition">

                                    Delete

                                </button>

                            </form>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="text-center py-10 text-gray-500">

                No availability slots added yet.

            </div>

        @endif

    </div>

</div>

<!-- CALENDAR (Flatpickr) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    let bookedDates = @json($bookedDates ?? []);
</script>

<script>
flatpickr("#availableDate", {
    dateFormat: "Y-m-d",
    minDate: "today",
     disable: bookedDates
});
</script>

@endsection