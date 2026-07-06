<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Two Factor Authentication') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Tambah lapisan keamanan dengan mengaktifkan autentikasi dua faktor (2FA).') }}
        </p>
    </header>

    <div class="mt-6">

        @if(auth()->user()->two_factor_secret)

            <div class="mb-4">
                <span class="text-green-600 font-semibold">
                    ✅ Two Factor Authentication Enabled
                </span>
            </div>

            {{-- QR Code --}}
            <div class="mt-6">
                <h3 class="font-semibold text-gray-900">
                    Scan QR Code menggunakan Google Authenticator
                </h3>

                <div class="mt-4">
                    {!! auth()->user()->twoFactorQrCodeSvg() !!}
                </div>
            </div>

            {{-- Secret Key --}}
            <div class="mt-6">
                <h3 class="font-semibold text-gray-900">
                    Secret Key
                </h3>

                <div class="mt-2 rounded bg-gray-100 p-3 font-mono break-all">
                    {{ decrypt(auth()->user()->two_factor_secret) }}
                </div>
            </div>

            {{-- ========================= --}}
            {{-- Konfirmasi OTP --}}
            {{-- ========================= --}}
            @if(is_null(auth()->user()->two_factor_confirmed_at))

                <div class="mt-6">
                    <h3 class="font-semibold text-gray-900">
                        Konfirmasi Two Factor Authentication
                    </h3>

                    <p class="text-sm text-gray-600 mt-2">
                        Masukkan kode 6 digit dari Google Authenticator untuk mengaktifkan 2FA.
                    </p>

                    <form method="POST"
                          action="{{ url('/user/confirmed-two-factor-authentication') }}"
                          class="mt-4">

                        @csrf

                        <input
                            type="text"
                            name="code"
                            maxlength="6"
                            class="border rounded w-full p-2"
                            placeholder="123456"
                            required>

                        <div class="mt-4">
                            <x-primary-button>
                                Confirm Two Factor Authentication
                            </x-primary-button>
                        </div>

                    </form>
                </div>

            @endif

            {{-- Recovery Codes --}}
            <div class="mt-6">
                <h3 class="font-semibold text-gray-900">
                    Recovery Codes
                </h3>

                <div class="mt-2 rounded bg-gray-100 p-4">
                    @if(method_exists(auth()->user(), 'recoveryCodes'))
                        @foreach(auth()->user()->recoveryCodes() as $code)
                            <div class="font-mono">
                                {{ $code }}
                            </div>
                        @endforeach
                    @else
                        <div class="text-sm text-red-500">
                            Recovery Codes tidak dapat ditampilkan.
                        </div>
                    @endif
                </div>
            </div>

            {{-- Regenerate Recovery Codes --}}
            <form method="POST"
                  action="{{ url('/user/two-factor-recovery-codes') }}"
                  class="mt-4">
                @csrf

                <x-secondary-button>
                    Regenerate Recovery Codes
                </x-secondary-button>
            </form>

            {{-- Disable 2FA --}}
            <form method="POST"
                  action="{{ url('/user/two-factor-authentication') }}"
                  class="mt-4">
                @csrf
                @method('DELETE')

                <x-danger-button>
                    Disable Two Factor Authentication
                </x-danger-button>
            </form>

        @else

            <div class="mb-4">
                <span class="text-red-600 font-semibold">
                    ❌ Two Factor Authentication Not Enabled
                </span>
            </div>

            <form method="POST"
                  action="{{ url('/user/two-factor-authentication') }}">
                @csrf

                <x-primary-button>
                    Enable Two Factor Authentication
                </x-primary-button>
            </form>

        @endif

    </div>
</section>