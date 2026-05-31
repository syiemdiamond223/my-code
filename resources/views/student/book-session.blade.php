@extends('layouts.student')

@section('content')

<div class="min-h-screen bg-gray-50 p-6">

    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-200 p-8">

        {{-- TITLE --}}
        <div class="mb-8">

            <h1 class="text-3xl font-bold text-gray-900">
                Book Session
            </h1>

            <p class="text-gray-500 mt-2">
                Complete the form below to book a tutoring session.
            </p>

        </div>

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        {{-- ERROR MESSAGE --}}
        @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-xl">
                {{ session('error') }}
            </div>
        @endif

        {{-- VALIDATION ERRORS --}}
        @if($errors->any())
            <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-xl">

                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        @endif

        {{-- TUTOR INFO --}}
        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6 mb-8">

            <div class="flex items-center gap-4">

                <div class="w-16 h-16 rounded-full bg-blue-600 text-white flex items-center justify-center text-2xl font-bold">
                    {{ strtoupper(substr($tutor->user->name ?? 'T', 0, 1)) }}
                </div>

                <div>

                    <h2 class="text-2xl font-bold text-gray-900">
                        {{ $tutor->user->name }}
                    </h2>

                    <p class="text-blue-700 mt-1 font-medium">
                        ₹{{ $tutor->price_per_hour }}/hr
                    </p>

                    <p class="text-sm text-gray-600 mt-1">

                        @forelse($tutor->subjects as $subject)
                            {{ $subject->name }}@if(!$loop->last), @endif
                        @empty
                            No subjects available
                        @endforelse

                    </p>

                    <p class="text-sm text-gray-500 mt-2">
                        Teaching Mode:
                        <span class="font-semibold text-blue-700">
                            {{ ucfirst($tutor->mode) }}
                        </span>
                    </p>

                </div>

            </div>

        </div>

        {{-- BOOKING FORM --}}
        <form method="POST"
              action="{{ route('student.booking.store', $tutor->id) }}">

            @csrf

            <input type="hidden"
                name="tutor_id"
                value="{{ $tutor->id }}">

            {{-- AVAILABILITY INSIDE FORM --}}
            <div class="bg-green-50 border border-green-200 rounded-2xl p-6 mb-8">

                <h3 class="text-lg font-bold text-green-800 mb-4">
                    Tutor Availability
                </h3>

                @if($tutor->availabilities->count())

                    <div class="space-y-3">

                       @foreach($tutor->availabilities as $slot)
                        <label class="block p-3 rounded mb-2 cursor-pointer border

                        @if($slot->status == 'unavailable')
                            bg-red-50 border-red-300
                        @else
                            bg-green-50 border-green-300
                        @endif
                        ">

                                <input type="radio"
                                       name="availability_id"
                                       value="{{ $slot->id }}"
                                        @if($slot->status == 'unavailable') disabled @else required @endif>

                                <div>
                                    <p>{{ $slot->available_date }}</p>
                                    <p>
                                        {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}
                                        -
                                        {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                                    </p>
                                       @if($slot->status == 'unavailable')
                                            <p class="text-red-600 font-semibold mt-2">
                                                ● Booked
                                            </p>
                                        @else
                                            <p class="text-green-600 font-semibold mt-2">
                                                ● Available
                                            </p>
                                        @endif
                                </div>

                            </label>

                        @endforeach

                    </div>

                @else

                    <p class="text-gray-500">
                        No availability added by tutor yet.
                    </p>

                @endif

            </div>

            {{-- SUBJECT --}}
            <div class="mb-6">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Select Subject
                </label>

                <select name="subject_id" required
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-black bg-white">

                    <option value="">Choose Subject</option>

                    @foreach($tutor->subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach

                </select>

            </div>

            {{-- HOURS --}}
            <div class="mb-6">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Number of Hours
                </label>

                <input type="number"
                       id="hours"
                       name="hours"
                       value="{{ old('hours', 1) }}"
                       min="1"
                       required
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 text-black bg-white">
            </div>

            {{-- SESSION MODE --}}
            <div class="mb-6">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Session Mode
                </label>

                <select name="session_mode"
                        id="session_mode"
                        required
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-black bg-white">

                    <option value="">Choose Mode</option>

                    @if($tutor->mode == 'online')
                        <option value="online">Online</option>
                    @elseif($tutor->mode == 'offline')
                        <option value="offline">Offline</option>
                    @elseif($tutor->mode == 'both')
                        <option value="online">Online</option>
                        <option value="offline">Offline</option>
                    @endif

                </select>

            </div>

            {{-- OFFLINE --}}
            <div id="offlineFields" class="hidden">

              <div class="bg-orange-50 border border-orange-200 rounded-2xl p-6 mb-6">

    <h3 class="text-lg font-bold text-orange-800 mb-4">
        Home Tutor Details
    </h3>

    <!-- Phone input restricted to exactly 10 digits -->
    <input type="text"
       name="student_phone"
       maxlength="10"
       pattern="[0-9]{10}"
       title="Phone number must be exactly 10 digits"
       oninput="this.value=this.value.replace(/[^0-9]/g,'')"
       class="w-full border p-3 rounded-xl mb-3"
       placeholder="Phone">

    <!-- Address input restricted to a maximum of 150 characters -->
    <textarea name="student_address"
              rows="4"
              maxlength="150"
              class="w-full border p-3 rounded-xl"
              placeholder="Address"></textarea>

</div>


            </div>

         {{-- PRICE --}}
        <div class="mb-8 bg-gray-50 border border-gray-200 rounded-xl p-4">

            <p class="text-sm text-gray-600 mb-1">
                Price Per Hour
            </p>

            <p class="text-lg font-semibold text-gray-700">
                ₹{{ $tutor->price_per_hour }}
            </p>

            <hr class="my-3">

            <p class="text-sm text-gray-600 mb-1">
                Total Price
            </p>

            <p id="totalPrice"
            class="text-2xl font-bold text-blue-600">
                ₹{{ $tutor->price_per_hour }}
            </p>

        </div>

            {{-- BUTTON --}}
            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-xl font-semibold">

                Confirm Booking

            </button>

        </form>

    </div>
</div>

<script>

//show/hide offline fields based on session mode selection
const sessionMode = document.getElementById('session_mode');
const offlineFields = document.getElementById('offlineFields');

// Show/hide offline fields based on session mode selection
function toggleOffline() {
    if (sessionMode.value === 'offline') {
        offlineFields.classList.remove('hidden');
    } else {
        offlineFields.classList.add('hidden');
    }
}

sessionMode.addEventListener('change', toggleOffline);
toggleOffline();


// PRICE CALCULATION
const hoursInput = document.getElementById('hours');
const totalPrice = document.getElementById('totalPrice');

const pricePerHour = {{ $tutor->price_per_hour }};

function updatePrice() {
    let hours = parseInt(hoursInput.value) || 1;
    totalPrice.innerText = '₹' + (pricePerHour * hours);
}

hoursInput.addEventListener('input', updatePrice);

updatePrice();

</script>

@endsection