<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <div class="mb-8 text-center sm:text-left">
        <h2 class="text-2xl font-bold text-white tracking-tight">Selamat Datang</h2>
        <p class="text-sm text-zinc-400 mt-1">Silakan masuk ke Sistem Manajemen Penyewaan Kendaraan.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Alamat Email" class="mb-1.5" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <x-input-label for="password" value="Kata Sandi" />
                @if (Route::has('password.request'))
                    <a class="text-xs text-amber-500 hover:text-amber-400 hover:underline transition-colors" href="{{ route('password.request') }}">
                        Lupa sandi?
                    </a>
                @endif
            </div>

            <x-text-input id="password" class="block w-full"
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                <input id="remember_me" type="checkbox" class="rounded border-zinc-800 bg-zinc-950/80 text-amber-500 shadow-sm focus:ring-amber-500 focus:ring-offset-zinc-900 w-4 h-4 transition-all" name="remember">
                <span class="ms-2.5 text-sm text-zinc-400">Ingat saya</span>
            </label>
        </div>

        <!-- Action Buttons -->
        <div class="pt-2">
            <x-primary-button class="w-full py-3.5">
                Masuk
            </x-primary-button>
        </div>

        <!-- Register Link -->
        <div class="text-center pt-4 border-t border-zinc-800/50 mt-6">
            <p class="text-sm text-zinc-400">
                Belum memiliki akun? 
                <a href="{{ route('register') }}" class="font-semibold text-amber-500 hover:text-amber-400 hover:underline transition-colors ms-1">
                    Daftar Sekarang
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
