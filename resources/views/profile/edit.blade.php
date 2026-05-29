@extends($layout)

@section('page-title', 'Profile Settings')

@section('page-subtitle', 'Manage your account settings')

@section('content')

<div class="space-y-6">

    {{-- PROFILE INFORMATION --}}
    <div class="bg-white rounded-2xl border border-blue-100 shadow-sm p-8">

        @include('profile.partials.update-profile-information-form')

    </div>


    {{-- UPDATE PASSWORD --}}
    <div class="bg-white rounded-2xl border border-blue-100 shadow-sm p-8">

        @include('profile.partials.update-password-form')

    </div>


    {{-- DELETE ACCOUNT --}}
    <div class="bg-white rounded-2xl border border-red-100 shadow-sm p-8">

        @include('profile.partials.delete-user-form')

    </div>

</div>

@endsection