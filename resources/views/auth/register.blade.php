<x-guest-layout>
    <div class="mb-8 text-center sm:text-left">
        <h2 class="text-2xl font-bold text-white tracking-tight">Buat Akun Baru</h2>
        <p class="text-sm text-zinc-400 mt-1">Daftar sekarang untuk mengelola persewaan kendaraan Anda.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" value="Nama Lengkap" class="mb-1.5" />
            <x-text-input id="name" class="block w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Alamat Email" class="mb-1.5" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" value="Kata Sandi" class="mb-1.5" />
            <x-text-input id="password" class="block w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password"
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" value="Konfirmasi Kata Sandi" class="mb-1.5" />
            <x-text-input id="password_confirmation" class="block w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
        </div>

        <!-- Action Button -->
        <div class="pt-2">
            <x-primary-button class="w-full py-3.5">
                Daftar
            </x-primary-button>
        </div>

        <!-- Login Link -->
        <div class="text-center pt-4 border-t border-zinc-800/50 mt-6">
            <p class="text-sm text-zinc-400">
                Sudah memiliki akun? 
                <a href="{{ route('login') }}" class="font-semibold text-amber-500 hover:text-amber-400 hover:underline transition-colors ms-1">
                    Masuk Di Sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
