<section>

    <header>

        <h2 class="text-lg font-semibold text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>

    </header>

    <form method="post"
          action="{{ route('password.update') }}"
          class="mt-6 space-y-6">

        @csrf
        @method('put')

        {{-- CURRENT PASSWORD --}}
        <div>

            <label for="update_password_current_password"
                   class="block text-sm font-medium text-gray-700 mb-2">

                Current Password

            </label>

            <input id="update_password_current_password"
                   name="current_password"
                   type="password"
                   autocomplete="current-password"
                   class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-white text-black focus:ring-2 focus:ring-blue-500 outline-none">

            <x-input-error
                :messages="$errors->updatePassword->get('current_password')"
                class="mt-2" />

        </div>


        {{-- NEW PASSWORD --}}
        <div>

            <label for="update_password_password"
                   class="block text-sm font-medium text-gray-700 mb-2">

                New Password

            </label>

            <input id="update_password_password"
                   name="password"
                   type="password"
                   autocomplete="new-password"
                   class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-white text-black focus:ring-2 focus:ring-blue-500 outline-none">

            <x-input-error
                :messages="$errors->updatePassword->get('password')"
                class="mt-2" />

        </div>


        {{-- CONFIRM PASSWORD --}}
        <div>

            <label for="update_password_password_confirmation"
                   class="block text-sm font-medium text-gray-700 mb-2">

                Confirm Password

            </label>

            <input id="update_password_password_confirmation"
                   name="password_confirmation"
                   type="password"
                   autocomplete="new-password"
                   class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-white text-black focus:ring-2 focus:ring-blue-500 outline-none">

            <x-input-error
                :messages="$errors->updatePassword->get('password_confirmation')"
                class="mt-2" />

        </div>


        {{-- BUTTON --}}
        <div class="flex items-center gap-4">

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition">

                Save

            </button>

            @if (session('status') === 'password-updated')

                <p x-data="{ show: true }"
                   x-show="show"
                   x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-green-600">

                    {{ __('Saved.') }}

                </p>

            @endif

        </div>

    </form>

</section>