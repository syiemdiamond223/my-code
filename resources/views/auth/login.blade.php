<x-guest-layout>

    <!-- Heading -->
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-blue-700">
            Log In
        </h1>

        <p class="text-sm text-gray-700 mt-2">
            Don’t have an account?

            <a href="{{ route('register') }}"
               class="text-blue-700 font-medium hover:underline">

                Sign Up Free

            </a>
        </p>
    </div>

    <!-- SUCCESS MESSAGE -->
    <x-auth-session-status
        class="mb-4 text-center text-sm text-green-600"
        :status="session('status')" />

    <!-- BLOCKED / LOGIN ERRORS -->
    @if ($errors->any())

        <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-700 rounded-xl">

            {{ $errors->first() }}

        </div>

    @endif

    <form method="POST" action="{{ route('login') }}">

        @csrf

        <!-- Email -->
        <div>

            <label class="block text-sm text-gray-700 mb-2">
                Email
            </label>

            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus

                class="w-full px-4 py-3 rounded-xl
                       bg-white border border-gray-300
                       focus:outline-none focus:ring-2 focus:ring-blue-400
                       transition"

                placeholder="Enter your email"
            >

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2 text-sm text-red-600"
            />

        </div>

        <!-- Password -->
        <div class="mt-6">

            <label class="block text-sm text-gray-700 mb-2">
                Password
            </label>

            <input
                type="password"
                name="password"
                required

                class="w-full px-4 py-3 rounded-xl
                       bg-white border border-gray-300
                       focus:outline-none focus:ring-2 focus:ring-blue-400
                       transition"

                placeholder="Enter your password"
            >

            <x-input-error
                :messages="$errors->get('password')"
                class="mt-2 text-sm text-red-600"
            />

        </div>

        <!-- Remember + Forgot -->
        <div class="flex justify-between items-center mt-6 text-sm">

            <label class="flex items-center space-x-2">

                <input
                    type="checkbox"
                    name="remember"
                    class="rounded text-blue-600 focus:ring-blue-400"
                >

                <span class="text-gray-700">
                    Remember me
                </span>

            </label>

            @if (Route::has('password.request'))

                <a href="{{ route('password.request') }}"
                   class="text-blue-700 hover:underline">

                    Forgot password?

                </a>

            @endif

        </div>

        <!-- Button -->
        <button
            type="submit"

            class="w-full mt-8 py-3 rounded-xl
                   bg-blue-600 hover:bg-blue-700
                   text-white font-semibold
                   shadow-md transition"
        >

            LOG IN

        </button>

    </form>

</x-guest-layout>