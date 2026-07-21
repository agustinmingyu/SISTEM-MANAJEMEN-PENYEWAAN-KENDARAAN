<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Panel</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-zinc-950 text-zinc-100 selection:bg-amber-500 selection:text-black">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-zinc-900 border-r border-zinc-800 text-zinc-100 flex flex-col hidden md:flex">

        <div class="p-5 text-2xl font-bold tracking-wider border-b border-zinc-800 flex items-center gap-2 text-white">
            <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
            </svg>
            AdminPanel
        </div>

        <nav class="flex-1 p-4 space-y-2 overflow-y-auto">

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-amber-500 text-black font-bold shadow' : 'text-zinc-400 hover:bg-zinc-800 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('admin.kendaraan.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.kendaraan.*') ? 'bg-amber-500 text-black font-bold shadow' : 'text-zinc-400 hover:bg-zinc-800 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13l2-5h14l2 5v6a1 1 0 01-1 1h-1a1 1 0 01-1-1v-1H6v1a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zm3 0h12M7 16h.01M17 16h.01"></path>
                </svg>
                Data Kendaraan
            </a>

            <a href="{{ route('admin.users.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.users.*') ? 'bg-amber-500 text-black font-bold shadow' : 'text-zinc-400 hover:bg-zinc-800 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                Data Pengguna
            </a>

            <a href="{{ route('admin.penyewaan.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.penyewaan.*') ? 'bg-amber-500 text-black font-bold shadow' : 'text-zinc-400 hover:bg-zinc-800 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Penyewaan
            </a>

            <a href="{{ route('admin.pembayaran.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.pembayaran.*') && ! request()->routeIs('admin.riwayat-pembayaran.*') ? 'bg-amber-500 text-black font-bold shadow' : 'text-zinc-400 hover:bg-zinc-800 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h2m2 0h6M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z"></path>
                </svg>
                Pembayaran
            </a>

            <a href="{{ route('admin.riwayat-pembayaran.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.riwayat-pembayaran.*') ? 'bg-amber-500 text-black font-bold shadow' : 'text-zinc-400 hover:bg-zinc-800 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Riwayat Pembayaran
            </a>

            <a href="{{ route('admin.laporan.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.laporan.*') ? 'bg-amber-500 text-black font-bold shadow' : 'text-zinc-400 hover:bg-zinc-800 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6m4 6V7m4 10V4M5 20h14"></path>
                </svg>
                Laporan
            </a>

            <a href="{{ route('admin.pengaturan.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.pengaturan.*') ? 'bg-amber-500 text-black font-bold shadow' : 'text-zinc-400 hover:bg-zinc-800 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                </svg>
                Pengaturan
            </a>

        </nav>

        <div class="p-4 border-t border-zinc-800 text-sm text-zinc-500 text-center">
            &copy; {{ date('Y') }} Admin Panel
        </div>

    </aside>

    <!-- Content -->
    <main class="flex-1 flex flex-col overflow-y-auto">

        <div class="bg-gradient-to-r from-amber-500 to-yellow-500 shadow px-6 py-4 flex justify-between items-center">

            <h2 class="text-2xl font-bold text-zinc-900">
                @yield('title')
            </h2>

            <div class="flex items-center gap-4">
                <div id="jamWIT" class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-lg bg-black/10 text-zinc-900 text-sm font-mono">
                    <svg class="w-4 h-4 text-zinc-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span id="jamWITText">--:--:--</span>
                    <span class="text-xs text-zinc-800/70">WIT</span>
                </div>

                <span class="text-zinc-900 text-sm font-medium">{{ Auth::user()->name }}</span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-zinc-800 hover:text-red-700 transition font-medium">
                        Keluar
                    </button>
                </form>
            </div>

        </div>

        <div class="p-6 flex-1">
            @yield('content')
        </div>

    </main>

</div>

@stack('scripts')

<script>
    function updateJamWIT() {
        // WIT = UTC+9
        const now = new Date();
        const utc = now.getTime() + (now.getTimezoneOffset() * 60000);
        const wit = new Date(utc + (9 * 3600000));

        const jam = String(wit.getHours()).padStart(2, '0');
        const menit = String(wit.getMinutes()).padStart(2, '0');
        const detik = String(wit.getSeconds()).padStart(2, '0');

        const el = document.getElementById('jamWITText');
        if (el) {
            el.textContent = `${jam}:${menit}:${detik}`;
        }
    }

    updateJamWIT();
    setInterval(updateJamWIT, 1000);
</script>

</body>
</html>