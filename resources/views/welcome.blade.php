<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sistem Manajemen Penyewaan Kendaraan</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts
          & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-zinc-950 text-zinc-100 min-h-screen relative overflow-x-hidden selection:bg-amber-500 selection:text-black">
        <!-- Background Ambient Glows -->
        <div class="absolute top-[-10%] left-[-15%] w-[800px] h-[800px] rounded-full bg-amber-500/5 blur-[150px] pointer-events-none"></div>
        <div class="absolute top-[40%] right-[-10%] w-[600px] h-[600px] rounded-full bg-zinc-800/10 blur-[130px] pointer-events-none"></div>
        <div class="absolute bottom-[-10%] left-[10%] w-[700px] h-[700px] rounded-full bg-amber-500/5 blur-[160px] pointer-events-none"></div>

        <!-- Header / Navigation -->
        <header class="w-full max-w-7xl mx-auto px-6 py-6 flex items-center justify-between relative z-20">
            <a href="/" class="flex items-center gap-3 group">
                <div class="p-2.5 bg-amber-500/10 border border-amber-500/30 rounded-xl text-amber-500 shadow-[0_0_15px_rgba(245,158,11,0.15)] group-hover:scale-105 transition-transform duration-300">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124l-.317-5.072a3.375 3.375 0 0 0-3.355-3.167H7.525a3.375 3.375 0 0 0-3.355 3.167l-.317 5.072c-.039.62.469 1.124 1.09 1.124H5.25M16.5 13.5H7.5M16.5 13.5v-3.75m0 3.75h-.375a1.125 1.125 0 0 1-1.125-1.125v-1.5a1.125 1.125 0 0 1 1.125-1.125h.375M7.5 13.5H7.125A1.125 1.125 0 0 0 6 14.625v1.5c0 .621.504 1.125 1.125 1.125H7.5M7.5 13.5V9.75m0 0h.375c.621 0 1.129.504 1.09 1.124v1.5c-.039.62-.469 1.124-1.09 1.124H7.5m0-3.75h8.25m0 0H16.5m-9 0V7.5A2.25 2.25 0 0 1 9.75 5.25h4.5A2.25 2.25 0 0 1 16.5 7.5v2.25"></path>
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-lg font-bold tracking-tight text-white group-hover:text-amber-500 transition-colors">RentApp</span>
                    <span class="text-[10px] text-zinc-400 font-medium tracking-widest uppercase">Management</span>
                </div>
            </a>

            @if (Route::has('login'))
                <nav class="flex items-center gap-2 sm:gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2 text-sm font-semibold text-black bg-amber-500 rounded-xl hover:bg-amber-400 active:scale-95 transition-all shadow-[0_4px_20px_rgba(245,158,11,0.25)]">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-zinc-300 hover:text-white transition-colors">
                            Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2 text-sm font-semibold text-white bg-zinc-900 border border-zinc-800 rounded-xl hover:bg-zinc-800 active:scale-95 hover:border-zinc-700 transition-all">
                                Daftar
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <!-- Hero Section -->
        <section class="max-w-7xl mx-auto px-6 pt-12 pb-24 relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Left Text Content -->
            <div class="lg:col-span-7 flex flex-col space-y-6 text-left">
                <!-- Badge -->
                <div class="inline-flex items-center self-start gap-2 px-3 py-1 bg-amber-500/10 border border-amber-500/20 rounded-full text-amber-500 text-xs font-semibold tracking-wide">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                    Sistem Manajemen Penyewaan Kendaraan
                </div>

                <!-- Main Heading -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white leading-[1.1]">
                    Kelola Persewaan <br />
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-500 via-orange-400 to-yellow-500">
                        Kendaraan Modern
                    </span>
                </h1>

                <p class="text-zinc-400 text-base sm:text-lg max-w-xl leading-relaxed">
                    Sistem manajemen terintegrasi untuk melacak armada, mengelola pemesanan pelanggan, memverifikasi data transaksi, dan memantau analitik keuangan secara real-time.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-2">
                    <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 px-8 py-4 bg-gradient-to-r from-amber-500 to-amber-600 text-black font-bold rounded-2xl hover:from-amber-400 hover:to-amber-500 active:scale-[0.98] transition-all shadow-[0_10px_30px_rgba(245,158,11,0.2)]">
                        <span>Mulai Sekarang</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
                        </svg>
                    </a>
                    <a href="#fitur" class="flex items-center justify-center px-8 py-4 bg-zinc-900 border border-zinc-800 text-zinc-300 font-semibold rounded-2xl hover:bg-zinc-800/80 hover:text-white transition-all">
                        Pelajari Fitur
                    </a>
                </div>

                <!-- Mini Stats inside Hero -->
                <div class="grid grid-cols-3 gap-6 pt-10 border-t border-zinc-900">
                    <div>
                        <div class="text-2xl sm:text-3xl font-extrabold text-white">200+</div>
                        <div class="text-xs text-zinc-500 uppercase tracking-wider font-semibold">Total Armada</div>
                    </div>
                    <div>
                        <div class="text-2xl sm:text-3xl font-extrabold text-white">500+</div>
                        <div class="text-xs text-zinc-500 uppercase tracking-wider font-semibold">Booking Selesai</div>
                    </div>
                    <div>
                        <div class="text-2xl sm:text-3xl font-extrabold text-white">99.9%</div>
                        <div class="text-xs text-zinc-500 uppercase tracking-wider font-semibold">Uptime Sistem</div>
                    </div>
                </div>
            </div>

            <!-- Right Visual Interactive Panel -->
            <div class="lg:col-span-5 relative flex justify-center lg:justify-end">
                <div class="w-full max-w-[450px] bg-zinc-900/90 border border-zinc-800 rounded-3xl p-6 shadow-2xl relative overflow-hidden backdrop-blur-md">
                    <!-- Glassmorphism decorative badge -->
                    <div class="absolute -top-3 -right-3 w-32 h-32 bg-amber-500/10 rounded-full blur-2xl"></div>

                    <!-- Panel Header -->
                    <div class="flex items-center justify-between border-b border-zinc-800 pb-4 mb-6">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-red-500/60"></span>
                            <span class="w-3 h-3 rounded-full bg-yellow-500/60"></span>
                            <span class="w-3 h-3 rounded-full bg-green-500/60"></span>
                        </div>
                        <span class="text-xs text-zinc-500 font-mono">live-dashboard.sh</span>
                    </div>

                    <!-- Visual Mockup Widget -->
                    <div class="space-y-4">
                        <!-- Vehicle Status Card 1 -->
                        <div class="p-4 bg-zinc-950/60 border border-zinc-800/80 rounded-2xl flex items-center justify-between hover:border-zinc-700/60 transition-all duration-300 group">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-amber-500/10 rounded-xl text-amber-500">
                                    <!-- SUV icon SVG -->
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-xs font-semibold text-white">Pajero Sport Sport Edition</h4>
                                    <p class="text-[10px] text-zinc-500">Mobil SUV • Plat B 1234 XYZ</p>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 bg-green-500/10 border border-green-500/20 text-[10px] text-green-500 font-semibold rounded-full">Tersedia</span>
                        </div>

                        <!-- Vehicle Status Card 2 -->
                        <div class="p-4 bg-zinc-950/60 border border-zinc-800/80 rounded-2xl flex items-center justify-between hover:border-zinc-700/60 transition-all duration-300">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-amber-500/10 rounded-xl text-amber-500">
                                    <!-- Motorbike icon SVG -->
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.3 12.3c.3.3.6.8.6 1.3 0 1.1-.9 2-2 2h-.8v1.6H12v-1.6h-.8c-1.1 0-2-.9-2-2 0-.5.2-1 .6-1.3"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-xs font-semibold text-white">Kawasaki ZX-25R Black</h4>
                                    <p class="text-[10px] text-zinc-500">Motor Sport • Plat F 8888 BB</p>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 bg-yellow-500/10 border border-yellow-500/20 text-[10px] text-yellow-500 font-semibold rounded-full">Disewa</span>
                        </div>

                        <!-- Mini OTP Verification Preview Widget -->
                        <div class="p-4 bg-zinc-950/60 border border-zinc-800/80 rounded-2xl space-y-2 relative overflow-hidden">
                            <div class="flex items-center justify-between border-b border-zinc-900 pb-2">
                                <span class="text-[10px] text-zinc-400 font-semibold uppercase tracking-wider">Verifikasi OTP Transaksi</span>
                                <span class="text-[10px] text-amber-500 font-semibold">Baru Kirim</span>
                            </div>
                            <div class="flex justify-between items-center gap-1 pt-1">
                                <span class="w-8 h-8 rounded-lg bg-zinc-900 border border-zinc-800 flex items-center justify-center text-xs font-bold text-amber-500">7</span>
                                <span class="w-8 h-8 rounded-lg bg-zinc-900 border border-zinc-800 flex items-center justify-center text-xs font-bold text-amber-500">2</span>
                                <span class="w-8 h-8 rounded-lg bg-zinc-900 border border-zinc-800 flex items-center justify-center text-xs font-bold text-amber-500">0</span>
                                <span class="w-8 h-8 rounded-lg bg-zinc-900 border border-zinc-800 flex items-center justify-center text-xs font-bold text-amber-500">9</span>
                            </div>
                            <div class="text-[9px] text-zinc-500 text-center">Kode verifikasi OTP dienkripsi dengan standar TLS 1.3</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="fitur" class="max-w-7xl mx-auto px-6 py-24 relative z-10 border-t border-zinc-900">
            <div class="text-center max-w-2xl mx-auto space-y-4 mb-16">
                <span class="text-amber-500 text-xs font-bold uppercase tracking-widest">Kelebihan Platform</span>
                <h2 class="text-3xl sm:text-4xl font-bold tracking-tight text-white">Dirancang Untuk Bisnis Penyewaan Modern</h2>
                <p class="text-zinc-400 text-sm sm:text-base">Dilengkapi dengan fitur canggih untuk mempermudah operasional sewa-menyewa kendaraan dalam satu platform.</p>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Feature 1 -->
                <div class="p-6 bg-zinc-900/40 border border-zinc-900 rounded-2xl hover:border-zinc-800 hover:bg-zinc-900/80 transition-all duration-300 flex flex-col space-y-4 group">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-500 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774a1.125 1.125 0 0 1 .12 1.45l-.527.737c-.25.35-.273.805-.108 1.205.166.397.505.71.93.78l.894.15c.542.09.94.56.94 1.11v1.094c0 .55-.398 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.93.78-.164.398-.142.854.108 1.205l.527.738a1.125 1.125 0 0 1-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.45.12l-.737-.527c-.35-.25-.805-.273-1.205-.108-.397.166-.71.505-.78.93l-.15.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.02-.398-1.11-.94l-.149-.894c-.07-.424-.383-.764-.78-.93-.398-.164-.854-.142-1.205.108l-.738.527a1.125 1.125 0 0 1-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.273-.805.108-1.205-.166-.397-.505-.71-.93-.78l-.894-.15a1.125 1.125 0 0 1-.94-1.11v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.764-.383.93-.78.164-.398.142-.854-.108-1.205l-.527-.738a1.125 1.125 0 0 1 .12-1.45l.774-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.805.273 1.205.108.397-.166.71-.505.78-.93l.15-.894z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white">Manajemen Armada</h3>
                    <p class="text-zinc-400 text-xs leading-relaxed">Pantau ketersediaan, status servis, serta jadwal sewa seluruh unit mobil dan motor secara real-time.</p>
                </div>

                <!-- Feature 2 -->
                <div class="p-6 bg-zinc-900/40 border border-zinc-900 rounded-2xl hover:border-zinc-800 hover:bg-zinc-900/80 transition-all duration-300 flex flex-col space-y-4 group">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-500 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white">Verifikasi Kode OTP</h3>
                    <p class="text-zinc-400 text-xs leading-relaxed">Keamanan tingkat tinggi menggunakan kode OTP untuk konfirmasi akun, transaksi sewa, dan pengembalian.</p>
                </div>

                <!-- Feature 3 -->
                <div class="p-6 bg-zinc-900/40 border border-zinc-900 rounded-2xl hover:border-zinc-800 hover:bg-zinc-900/80 transition-all duration-300 flex flex-col space-y-4 group">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-500 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white">Penjadwalan Otomatis</h3>
                    <p class="text-zinc-400 text-xs leading-relaxed">Pengingat otomatis untuk pengembalian kendaraan guna menghindari keterlambatan dan denda.</p>
                </div>

                <!-- Feature 4 -->
                <div class="p-6 bg-zinc-900/40 border border-zinc-900 rounded-2xl hover:border-zinc-800 hover:bg-zinc-900/80 transition-all duration-300 flex flex-col space-y-4 group">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-500 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white">Laporan Keuangan</h3>
                    <p class="text-zinc-400 text-xs leading-relaxed">Dashboard lengkap dengan metrik laba rugi, total biaya operasional, dan statistik performa bisnis.</p>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="border-t border-zinc-900 py-8 text-center text-xs text-zinc-600 relative z-10 max-w-7xl mx-auto px-6">
            <p>&copy; 2026 Sistem Manajemen Penyewaan Kendaraan (RentApp). All rights reserved.</p>
        </footer>
    </body>
</html>
