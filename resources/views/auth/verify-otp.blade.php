<x-guest-layout>
    <div class="mb-8 text-center sm:text-left">
        <!-- Shield Icon with Pulsing Effect -->
        <div class="flex justify-center sm:justify-start mb-4">
            <div class="p-3 bg-amber-500/10 border border-amber-500/30 rounded-2xl text-amber-500 relative">
                <span class="absolute top-0 right-0 w-2 h-2 rounded-full bg-amber-500 animate-ping"></span>
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"></path>
                </svg>
            </div>
        </div>
        <h2 class="text-2xl font-bold text-white tracking-tight">Verifikasi Kode OTP</h2>
        <p class="text-sm text-zinc-400 mt-1">Kami telah mengirimkan 6 digit kode OTP ke kontak terdaftar Anda untuk autentikasi keamanan.</p>
    </div>

    <!-- Session Status / Errors -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    @if ($errors->any())
        <div class="mb-4 p-3.5 bg-red-500/10 border border-red-500/20 text-red-400 text-sm rounded-xl">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ url('verify-otp') }}" class="space-y-6" id="otp-form">
        @csrf

        <!-- Single hidden input to submit the concatenated OTP value -->
        <input type="hidden" name="otp" id="otp-value" value="">

        <!-- Custom OTP 6-Digit Fields -->
        <div>
            <x-input-label value="Masukkan 6 Digit OTP" class="mb-3 text-center sm:text-left" />
            <div class="flex justify-between items-center gap-2" id="otp-inputs">
                @for ($i = 1; $i <= 6; $i++)
                    <input type="text" 
                           id="otp-{{ $i }}" 
                           maxlength="1" 
                           class="w-12 h-14 text-center text-xl font-bold rounded-xl border-zinc-800 bg-zinc-950/80 text-white placeholder-zinc-700 focus:border-amber-500 focus:ring-amber-500 focus:ring-1 focus:outline-none transition-all duration-150" 
                           pattern="[0-9]*" 
                           inputmode="numeric" 
                           autocomplete="off">
                @endfor
            </div>
        </div>

        <!-- Action Button -->
        <div class="pt-2">
            <x-primary-button class="w-full py-3.5" id="submit-btn">
                Verifikasi & Masuk
            </x-primary-button>
        </div>

        <!-- Resend OTP timer -->
        <div class="text-center pt-2">
            <p class="text-sm text-zinc-400">
                Tidak menerima kode? 
                <span id="countdown-wrapper" class="text-zinc-500 font-medium">
                    Kirim ulang dalam <span id="timer" class="text-amber-500 font-bold">59</span>s
                </span>
                <button type="button" id="resend-link" class="hidden text-amber-500 hover:text-amber-400 font-semibold hover:underline transition-colors focus:outline-none">
                    Kirim Ulang Kode
                </button>
            </p>
        </div>
    </form>

    <!-- Custom Script for Interactive OTP Box jumps & Timer -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const inputs = document.querySelectorAll('#otp-inputs input');
            const hiddenInput = document.getElementById('otp-value');
            const form = document.getElementById('otp-form');
            const resendLink = document.getElementById('resend-link');
            const countdownWrapper = document.getElementById('countdown-wrapper');
            const timerEl = document.getElementById('timer');

            // 1. Focus Flow Logic
            inputs.forEach((input, index) => {
                input.addEventListener('input', (e) => {
                    // Only allow digits
                    input.value = input.value.replace(/[^0-9]/g, '');

                    if (input.value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                    updateHiddenValue();
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace') {
                        if (input.value.length === 0 && index > 0) {
                            inputs[index - 1].focus();
                            inputs[index - 1].value = '';
                        } else {
                            input.value = '';
                        }
                        updateHiddenValue();
                        e.preventDefault();
                    }
                });

                // Auto paste support
                input.addEventListener('paste', (e) => {
                    e.preventDefault();
                    const pastedData = e.clipboardData.getData('text').trim();
                    if (/^\d{6}$/.test(pastedData)) {
                        for (let i = 0; i < inputs.length; i++) {
                            inputs[i].value = pastedData[i];
                        }
                        inputs[inputs.length - 1].focus();
                        updateHiddenValue();
                    }
                });
            });

            function updateHiddenValue() {
                let code = '';
                inputs.forEach(input => {
                    code += input.value;
                });
                hiddenInput.value = code;
            }

            // Form Submit validation
            form.addEventListener('submit', (e) => {
                updateHiddenValue();
                if (hiddenInput.value.length !== 6) {
                    e.preventDefault();
                    alert('Harap masukkan 6 digit kode OTP secara lengkap.');
                }
            });

            // 2. Countdown Timer for Resending OTP
            let count = 59;
            const interval = setInterval(() => {
                count--;
                timerEl.textContent = count;
                if (count <= 0) {
                    clearInterval(interval);
                    countdownWrapper.classList.add('hidden');
                    resendLink.classList.remove('hidden');
                }
            }, 1000);

            // Handle resend click mock behavior
            resendLink.addEventListener('click', () => {
                alert('Kode OTP baru telah dikirimkan ke kontak Anda.');
                // reset count down timer
                count = 59;
                timerEl.textContent = count;
                countdownWrapper.classList.remove('hidden');
                resendLink.classList.add('hidden');
                
                // start timer again
                const newInterval = setInterval(() => {
                    count--;
                    timerEl.textContent = count;
                    if (count <= 0) {
                        clearInterval(newInterval);
                        countdownWrapper.classList.add('hidden');
                        resendLink.classList.remove('hidden');
                    }
                }, 1000);
            });
        });
    </script>
</x-guest-layout>
