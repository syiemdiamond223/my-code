<x-guest-layout>

    <div class="mb-5 text-2xl font-bold text-gray-800">
        Reset Your Password
    </div>

    <p class="text-gray-600 mb-6">
        Enter your new password below.
    </p>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden"
               name="token"
               value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label
                for="email"
                class="text-gray-800 font-semibold text-base"
                :value="__('Email')"
            />

            <x-text-input
                id="email"
                class="block mt-2 w-full rounded-xl border-gray-300 py-3 px-4 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                type="email"
                name="email"
                :value="old('email', $request->email)"
                required
                autofocus
                autocomplete="username"
            />

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2"
            />
        </div>

        <!-- Password -->
        <div class="mt-5">

            <x-input-label
                for="password"
                class="text-gray-800 font-semibold text-base"
                :value="__('Password')"
            />

            <x-text-input
                id="password"
                class="block mt-2 w-full rounded-xl border-gray-300 py-3 px-4 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                type="password"
                name="password"
                required
                autocomplete="new-password"
            />

            <x-input-error
                :messages="$errors->get('password')"
                class="mt-2"
            />

        </div>

        <!-- Confirm Password -->
        <div class="mt-5">

            <x-input-label
                for="password_confirmation"
                class="text-gray-800 font-semibold text-base"
                :value="__('Confirm Password')"
            />

            <x-text-input
                id="password_confirmation"
                class="block mt-2 w-full rounded-xl border-gray-300 py-3 px-4 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
            />

            <x-input-error
                :messages="$errors->get('password_confirmation')"
                class="mt-2"
            />

        </div>

        <!-- Button -->
        <div class="flex items-center justify-end mt-8">

            <x-primary-button
                class="px-6 py-3 rounded-xl text-sm font-semibold"
            >
                {{ __('Reset Password') }}
            </x-primary-button>

        </div>

    </form>

</x-guest-layout>