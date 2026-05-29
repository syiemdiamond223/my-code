<section>

    <header>

        <h2 class="text-lg font-semibold text-red-600">
            Delete Account
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Once your account is deleted, all of its resources and data will be permanently deleted.
        </p>

    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="mt-6 bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-semibold transition"
    >
        Delete Account
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>

        <form method="post"
              action="{{ route('profile.destroy') }}"
              class="p-6 bg-white rounded-2xl">

            @csrf
            @method('delete')

            <h2 class="text-xl font-bold text-red-600">
                Are you sure you want to delete your account?
            </h2>

            <p class="mt-2 text-sm text-gray-600">
                Once your account is deleted, all of your data will be permanently removed.
                Please enter your password to confirm.
            </p>

            {{-- PASSWORD --}}
            <div class="mt-6">

                <label for="password"
                       class="block text-sm font-medium text-gray-700 mb-2">

                    Password

                </label>

                <input id="password"
                       name="password"
                       type="password"
                       placeholder="Enter your password"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-white text-black focus:ring-2 focus:ring-red-500 outline-none">

                <x-input-error
                    :messages="$errors->userDeletion->get('password')"
                    class="mt-2" />

            </div>

            {{-- BUTTONS --}}
            <div class="mt-6 flex justify-end gap-4">

                <button type="button"
                        x-on:click="$dispatch('close')"
                        class="px-5 py-2 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100 transition">

                    Cancel

                </button>

                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-semibold transition">

                    Delete Account

                </button>

            </div>

        </form>

    </x-modal>

</section>