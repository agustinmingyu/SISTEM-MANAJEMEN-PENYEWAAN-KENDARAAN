<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Panel</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-zinc-950 text-white">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-zinc-800 text-white">

        <div class="p-5 text-2xl font-bold border-b border-zinc-800">
            Admin Panel
        </div>

        <nav class="flex-1 p-4 space-y-2">

    <a href="{{ route('admin.dashboard') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-xl bg-amber-500 text-black font-bold shadow hover:bg-amber-400 transition">
        🏠 Dashboard
    </a>

    <a href="{{ route('admin.kendaraan.index') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-xl text-zinc-300 hover:bg-zinc-800 hover:text-white transition">
        🚗 Data Kendaraan
    </a>

    <a href="{{ route('admin.penyewaan.index') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-xl text-zinc-300 hover:bg-zinc-800 hover:text-white transition">
        📄 Penyewaan
    </a>

    <a href="{{ route('admin.pembayaran.index') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-xl text-zinc-300 hover:bg-zinc-800 hover:text-white transition">
        💳 Pembayaran
    </a>

    <a href="{{ route('admin.laporan.index') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-xl text-zinc-300 hover:bg-zinc-800 hover:text-white transition">
        📊 Laporan
    </a>

</nav>
    </aside>

    <!-- Content -->
    <main class="flex-1">

        <div class="bg-white shadow p-5 flex justify-between">

            <h2 class="text-2xl font-bold">
                @yield('title')
            </h2>

            <div>
                {{ Auth::user()->name }}
            </div>

        </div>

        <div class="p-6">

            @yield('content')

        </div>

    </main>

</div>

</body>
</html>