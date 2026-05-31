@extends('layouts.tutor')

@section('page-title', 'Create / Edit Profile')

@section('page-subtitle', ' Complete your tutor profile to start accepting student bookings.')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-slate-100 via-blue-50 to-gray-100 py-8">

    <div class="max-w-4xl mx-auto">

        {{-- HEADER --}}
        <div class="bg-white/70 backdrop-blur-md rounded-2xl border border-white/40 shadow-lg p-8 mb-6">

            <h1 class="text-3xl font-bold text-black">
                {{ isset($tutor) ? 'Edit Profile' : 'Create Profile' }}
            </h1>

        </div>


        {{-- FORM --}}
        <div class="bg-white/75 backdrop-blur-lg rounded-2xl border border-white/50 shadow-xl p-8">

            <form method="POST"
                  action="{{ isset($tutor) ? route('tutor.profile.update') : route('tutor.profile.store') }}"
                  class="space-y-6">

                @csrf

                @if(isset($tutor))
                    @method('PUT')
                @endif

                {{-- NAME --}}
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Name
                    </label>

                    <input type="text"
                           name="name"
                           value="{{ old('name', Auth::user()->name) }}"
                           placeholder="Enter your full name"
                           pattern="[A-Za-z\s]+"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-black placeholder:text-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                           required>

                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                </div>


                {{-- EMAIL --}}
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Email
                    </label>

                    <input type="email"
                           name="email"
                           value="{{ old('email', Auth::user()->email) }}"
                           placeholder="Enter your email"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-black placeholder:text-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                           required>

                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                </div>


                {{-- PHONE --}}
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Phone
                    </label>

                    <input type="tel"
                           name="phone"
                           id="phone"
                           value="{{ old('phone', $tutor->phone ?? '') }}"
                           placeholder="Enter 10-digit phone number"
                           maxlength="10"
                           inputmode="numeric"
                           pattern="[0-9]{10}"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,10)"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-black placeholder:text-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                           required>

                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                </div>


                {{-- QUALIFICATION --}}
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Qualification
                    </label>

                    <select name="qualification"
                            id="qualification"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-black focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                            required>

                        <option value="">Select Qualification</option>

                        @foreach($qualifications as $qualification)

                            <option value="{{ $qualification }}"
                                {{ old('qualification', $tutor->qualification ?? '') == $qualification ? 'selected' : '' }}>

                                {{ $qualification }}

                            </option>

                        @endforeach

                    </select>

                    {{-- OTHER QUALIFICATION --}}
                    <input type="text"
                           name="other_qualification"
                           id="other_qualification"
                           value="{{ old('other_qualification') }}"
                           placeholder="Enter your qualification"
                           class="w-full mt-3 border border-gray-300 rounded-xl px-4 py-3 text-black placeholder:text-gray-500 hidden">

                </div>


                {{-- EXPERIENCE --}}
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Experience (Years)
                    </label>

                    <select name="experience"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-black focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                            required>

                        <option value="">Select Experience</option>

                        {{-- Loop from 1 to 5 years for experience options --}}
                        @for($i = 1; $i <= 5; $i++)

                            <option value="{{ $i }}"
                                {{ old('experience', $tutor->experience ?? '') == $i ? 'selected' : '' }}>

                                {{ $i }} Year{{ $i > 1 ? 's' : '' }}

                            </option>

                        @endfor

                    </select>

                </div>


                {{-- INSTITUTION --}}
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Institution
                    </label>

                    <select name="institution"
                            id="institution"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-black focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                            required>

                        <option value="">Select Institution</option>

                        @foreach($institutions as $institution)

                            <option value="{{ $institution }}"
                                {{ old('institution', $tutor->institution ?? '') == $institution ? 'selected' : '' }}>

                                {{ $institution }}

                            </option>

                        @endforeach

                    </select>

                    {{-- OTHER INSTITUTION --}}
                    <input type="text"
                           name="other_institution"
                           id="other_institution"
                           value="{{ old('other_institution') }}"
                           placeholder="Enter institution name"
                           class="w-full mt-3 border border-gray-300 rounded-xl px-4 py-3 text-black placeholder:text-gray-500 hidden">

                </div>


                {{-- PRICE --}}
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Price Per Hour
                    </label>

                    <input type="number"
                           name="price"
                           value="{{ old('price', $tutor->price_per_hour ?? '') }}"
                           placeholder="Enter your hourly rate"
                           min="1"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-black placeholder:text-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                           required>

                </div>

                {{-- TEACHING MODE --}}
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Teaching Mode
                    </label>

                    <select name="mode"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-black focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                            required>

                        <option value="">Select Mode</option>

                        <option value="online"
                            {{ old('mode', $tutor->mode ?? '') == 'online' ? 'selected' : '' }}>
                            Online
                        </option>

                        <option value="offline"
                            {{ old('mode', $tutor->mode ?? '') == 'offline' ? 'selected' : '' }}>
                            Offline
                        </option>

                        <option value="both"
                            {{ old('mode', $tutor->mode ?? '') == 'both' ? 'selected' : '' }}>
                            Both
                        </option>

                    </select>

                    @error('mode')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- SUBJECTS --}}
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        Subjects You Teach
                    </label>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                        @foreach($subjects as $subject)

                            <label class="flex items-center gap-3 border border-gray-300 rounded-xl px-4 py-3 hover:bg-blue-50 transition cursor-pointer">

                                <!-- Check if the subject is in the old input (in case of validation error) or in the tutor's existing subjects (when editing) -->
                                <input type="checkbox"
                                    name="subjects[]"
                                    value="{{ $subject->id }}"
                                    class="w-5 h-5 text-blue-600 rounded"

                                    {{ in_array(
                                            $subject->id,
                                            old(
                                                'subjects',
                                                isset($tutor)
                                                    ? $tutor->subjects->pluck('id')->toArray()
                                                    : []
                                            )
                                    ) ? 'checked' : '' }}>

                                <span class="text-gray-800 font-medium">
                                    {{ $subject->name }}
                                </span>

                            </label>

                        @endforeach

                    </div>

                    @error('subjects')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- BIO --}}
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        About
                    </label>

                    <textarea name="bio"
                              rows="5"
                              minlength="20"
                              maxlength="500"
                              placeholder="Tell students about yourself..."
                              class="w-full border border-gray-300 rounded-xl px-4 py-3 text-black placeholder:text-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">{{ old('bio', $tutor->bio ?? '') }}</textarea>

                </div>


                {{-- SUBMIT --}}
                <button type="submit"
                        class="w-full bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-700 transition duration-200">

                    {{ isset($tutor) ? 'Update Profile' : 'Create Profile' }}

                </button>

            </form>

        </div>

    </div>

</div>



{{-- TOGGLE OTHER FIELDS --}}
<script>

document.addEventListener('DOMContentLoaded', function () {

    const qualificationSelect = document.getElementById('qualification');
    const otherQualification = document.getElementById('other_qualification');

    const institutionSelect = document.getElementById('institution');
    const otherInstitution = document.getElementById('other_institution');


    function toggleQualification() {

        if (qualificationSelect.value === 'Other') {

            otherQualification.classList.remove('hidden');

        } else {

            otherQualification.classList.add('hidden');

        }

    }


    function toggleInstitution() {

        if (institutionSelect.value === 'Other') {

            otherInstitution.classList.remove('hidden');

        } else {

            otherInstitution.classList.add('hidden');

        }

    }


    toggleQualification();
    toggleInstitution();

    qualificationSelect.addEventListener('change', toggleQualification);
    institutionSelect.addEventListener('change', toggleInstitution);

});

</script>

@endsection