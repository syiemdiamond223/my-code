@extends('layouts.admin')

@section('page-title', 'Approve Tutors')
@section('page-subtitle', 'Manage tutor approval requests')

@section('content')

<div class="bg-white rounded-2xl shadow-sm p-6">

    <h2 class="text-2xl font-bold text-purple-900 mb-6">
        Approve Tutors
    </h2>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    {{-- ERRORS --}}
    @if($errors->any())
        <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-xl">
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="overflow-x-auto">

        <table class="w-full border-collapse text-gray-800">

            <thead>
                <tr class="bg-purple-100 text-left text-purple-900">
                    <th class="p-4">Tutor</th>
                    <th class="p-4">Phone</th>
                    <th class="p-4">Price</th>
                    <th class="p-4">Status</th>
                    <th class="p-4">Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($tutors as $tutor)

                <tr class="border-b">

                    <td class="p-4 font-medium">
                        {{ $tutor->user->name }}
                    </td>

                    <td class="p-4">
                        {{ $tutor->phone }}
                    </td>

                    <td class="p-4">
                        ₹{{ $tutor->price_per_hour }}
                    </td>

                    <td class="p-4">

                        @if($tutor->status == 'approved')
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                Approved
                            </span>

                        @elseif($tutor->status == 'rejected')
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
                                Rejected
                            </span>

                        @else
                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">
                                Pending
                            </span>
                        @endif

                    </td>

                    {{-- FIXED ACTIONS ONLY --}}
                    <td class="p-4">

            <div class="flex gap-2 items-center">

                <a href="{{ route('admin.tutors.show', $tutor->id) }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                        View Profile
                    </a>

                </div>

            </td>
    </span>

    </div>
    </td>
    </tr>
                @empty

                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-500">
                        No tutors found.
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection