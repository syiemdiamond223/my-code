<x-guest-layout>

    <!-- Heading -->
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-blue-700">
            Register
        </h1>
        <p class="text-sm text-gray-700 mt-2">
            Already have an account?
            <a href="{{ route('login') }}"
               class="text-blue-700 font-medium hover:underline">
                Log In
            </a>
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <label class="block text-sm text-gray-700 mb-2">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                class="w-full px-4 py-3 rounded-xl
                       bg-white border border-gray-300
                       focus:outline-none focus:ring-2 focus:ring-blue-400
                       transition"
                placeholder="Enter your name">
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Email -->
        <div class="mt-6">
            <label class="block text-sm text-gray-700 mb-2">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="w-full px-4 py-3 rounded-xl
                       bg-white border border-gray-300
                       focus:outline-none focus:ring-2 focus:ring-blue-400
                       transition"
                placeholder="Enter your email">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Role -->
        <div class="mt-6">
            <label class="block text-sm text-gray-700 mb-2">Register As</label>

            <select name="role"
                class="w-full px-4 py-3 rounded-xl
                    bg-white border border-gray-300
                    focus:outline-none focus:ring-2 focus:ring-blue-400
                    transition">

                <option value="student">Student</option>
                <option value="tutor">Tutor</option>
            </select>
        </div>

        <!-- Password -->
        <div class="mt-6">
            <label class="block text-sm text-gray-700 mb-2">Password</label>
            <input type="password" name="password" required
                class="w-full px-4 py-3 rounded-xl
                       bg-white border border-gray-300
                       focus:outline-none focus:ring-2 focus:ring-blue-400
                       transition"
                placeholder="Create password">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-6">
            <label class="block text-sm text-gray-700 mb-2">Confirm Password</label>
            <input type="password" name="password_confirmation" required
                class="w-full px-4 py-3 rounded-xl
                       bg-white border border-gray-300
                       focus:outline-none focus:ring-2 focus:ring-blue-400
                       transition"
                placeholder="Confirm password">
        </div>

        <!-- Button -->
        <button type="submit"
            class="w-full mt-8 py-3 rounded-xl
                   bg-blue-600 hover:bg-blue-700
                   text-white font-semibold
                   shadow-md transition">
            REGISTER
        </button>

    </form>

</x-guest-layout>