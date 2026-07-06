<x-guest-layout>

    <div class="mb-4 text-sm text-gray-600">
        {{ __('Masukkan kode dari Google Authenticator.') }}
    </div>

    <form method="POST" action="{{ route('two-factor.login.store') }}">
        @csrf

        <div>
            <x-input-label
                for="code"
                :value="__('Authentication Code')" />

            <x-text-input
                id="code"
                class="block mt-1 w-full"
                type="text"
                name="code"
                autofocus
                autocomplete="one-time-code" />

            <x-input-error
                :messages="$errors->get('code')"
                class="mt-2" />
        </div>

        <div class="mt-6">
            <x-input-label
                for="recovery_code"
                :value="__('Recovery Code')" />

            <x-text-input
                id="recovery_code"
                class="block mt-1 w-full"
                type="text"
                name="recovery_code"
                autocomplete="one-time-code" />

            <x-input-error
                :messages="$errors->get('recovery_code')"
                class="mt-2" />
        </div>

        <div class="flex justify-end mt-6">
            <x-primary-button>
                Login
            </x-primary-button>
        </div>

    </form>

</x-guest-layout>