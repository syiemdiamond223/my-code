<x-guest-layout>

    <div class="mb-6 text-2xl font-semibold text-gray-800">
        Enter your email to reset your password.
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>

            <label for="email"
                   class="block text-lg font-medium text-gray-800 mb-2">

                Email

            </label>

            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus

                class="w-full rounded-2xl border border-gray-300
                       px-5 py-4 text-lg text-gray-800
                       placeholder-gray-500
                       focus:ring-2 focus:ring-blue-500
                       focus:border-blue-500"
            >

            <x-input-error :messages="$errors->get('email')" class="mt-2" />

        </div>

        <div class="flex justify-end mt-8">

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700
                           text-white font-semibold
                           px-8 py-3 rounded-2xl transition">

                Reset Password

            </button>

        </div>

    </form>

</x-guest-layout>