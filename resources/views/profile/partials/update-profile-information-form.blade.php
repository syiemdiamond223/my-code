<section>

    <header>

        <h2 class="text-lg font-semibold text-gray-900">
            Profile Information
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Update your account's profile information and email address.
        </p>

    </header>

    <form id="send-verification"
          method="post"
          action="{{ route('verification.send') }}">

        @csrf

    </form>

    <form method="post"
          action="{{ route('profile.update') }}"
          class="mt-6 space-y-6">

        @csrf
        @method('patch')

        {{-- NAME --}}
        <div>

            <label for="name"
                   class="block text-sm font-medium text-gray-700 mb-2">

                Name

            </label>

            <input id="name"
                   name="name"
                   type="text"
                   value="{{ old('name', $user->name) }}"
                   required
                   autofocus
                   autocomplete="name"
                   class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-white text-black focus:ring-2 focus:ring-blue-500 outline-none">

            @error('name')

                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- EMAIL --}}
        <div>

            <label for="email"
                   class="block text-sm font-medium text-gray-700 mb-2">

                Email

            </label>

            <input id="email"
                   name="email"
                   type="email"
                   value="{{ old('email', $user->email) }}"
                   required
                   autocomplete="username"
                   class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-white text-black focus:ring-2 focus:ring-blue-500 outline-none">

            @error('email')

                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- VERIFY EMAIL --}}
        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())

            <div>

                <p class="text-sm text-gray-600">

                    Your email address is unverified.

                    <button form="send-verification"
                            class="underline text-blue-600 hover:text-blue-800 rounded-md focus:outline-none">

                        Click here to re-send the verification email.

                    </button>

                </p>

                @if (session('status') === 'verification-link-sent')

                    <p class="mt-2 text-sm text-green-600">

                        A new verification link has been sent.

                    </p>

                @endif

            </div>

        @endif


        {{-- BUTTON --}}
        <div class="flex items-center gap-4">

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition">

                Save

            </button>

            @if (session('status') === 'profile-updated')

                <p class="text-sm text-green-600">

                    Saved successfully.

                </p>

            @endif

        </div>

    </form>

</section>