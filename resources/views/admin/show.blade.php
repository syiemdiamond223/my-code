@extends('layouts.admin')

@section('page-title', 'Tutor Profile Review')
@section('page-subtitle', 'Review tutor details before approval')

@section('content')

<div class="bg-white p-6 rounded-xl shadow">

    <h2 class="text-2xl font-bold mb-6">
        Tutor Profile Review
    </h2>

    {{-- BASIC INFO --}}
    <div class="space-y-2 text-gray-800">

        <p><b>Name:</b> {{ $tutor->user->name }}</p>
        <p><b>Email:</b> {{ $tutor->user->email }}</p>
        <p><b>Phone:</b> {{ $tutor->phone }}</p>
        <p><b>Price:</b> ₹{{ $tutor->price_per_hour }}</p>
        <p><b>Mode:</b> {{ ucfirst($tutor->mode) }}</p>

        <p><b>Qualification:</b> {{ $tutor->qualification }}</p>
        <p><b>Experience:</b> {{ $tutor->experience }} years</p>
        <p><b>Institution:</b> {{ $tutor->institution }}</p>

    </div>

    <hr class="my-6">

    {{-- BIO --}}
    <div>
        <h3 class="font-semibold mb-2">Bio</h3>
        <p class="text-gray-700">{{ $tutor->bio }}</p>
    </div>

    <hr class="my-6">

    {{-- SUBJECTS --}}
    <div>
        <h3 class="font-semibold mb-2">Subjects</h3>

        <ul class="list-disc ml-6 text-gray-700">
            @foreach($tutor->subjects as $subject)
                <li>{{ $subject->name }}</li>
            @endforeach
        </ul>
    </div>

    <hr class="my-6">

    {{-- ACTIONS --}}
    @if($tutor->status == 'pending')

        <div class="flex gap-4">

            {{-- APPROVE --}}
            <form method="POST" action="{{ route('admin.tutors.approve', $tutor->id) }}">
                @csrf
                @method('PATCH')

                <button class="bg-green-600 text-white px-6 py-2 rounded-lg">
                    Approve
                </button>
            </form>

            {{-- REJECT --}}
            <form method="POST" action="{{ route('admin.tutors.reject', $tutor->id) }}">
                @csrf
                @method('PATCH')

                <input type="text"
                       name="rejection_message"
                       placeholder="Rejection reason"
                       class="border px-3 py-2 rounded">

                <button class="bg-red-600 text-white px-6 py-2 rounded-lg">
                    Reject
                </button>
            </form>

        </div>

    @else

        <p class="text-gray-600">
            This tutor is already {{ $tutor->status }}.
        </p>

        @if($tutor->rejection_message)
            <p class="text-red-600 mt-2">
                Reason: {{ $tutor->rejection_message }}
            </p>
        @endif

    @endif

</div>

@endsection