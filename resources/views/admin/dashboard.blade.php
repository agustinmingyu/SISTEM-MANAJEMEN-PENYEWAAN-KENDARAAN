<x-app-layout class="font-sans antialiased bg-zinc-950 text-zinc-100 min-h-screen relative overflow-x-hidden selection:bg-amber-500 selection:text-black">
    <div class="flex h-screen bg-zinc-950 font-sans backend-body">
        
        <aside class="w-64 bg-zinc-900 border-r border-zinc-800 text-zinc-100 flex flex-col hidden md:flex">
            <div class="p-5 text-2xl font-bold tracking-wider border-b border-zinc-800 flex items-center gap-2 text-white">
                <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                </svg>
                AdminPanel
            </div>
            
            <nav class="flex-1 p-4 space-y-2">
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 bg-amber-500 text-black rounded-xl transition font-bold shadow-[0_4px_15px_rgba(245,158,11,0.15)]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-zinc-400 hover:bg-zinc-800 hover:text-white rounded-xl transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    Pengguna
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-zinc-400 hover:bg-zinc-800 hover:text-white rounded-xl transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Produk
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-zinc-400 hover:bg-zinc-800 hover:text-white rounded-xl transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0h6m2 0h2a2 2 0 002-2v-3a2 2 0 00-2-2h-2a2 2 0 00-2 2v3a2 2 0 002 2z"></path>
                    </svg>
                    Laporan
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-zinc-400 hover:bg-zinc-800 hover:text-white rounded-xl transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    </svg>
                    Pengaturan
                </a>
            </nav>

            <div class="p-4 border-t border-zinc-800 text-sm text-zinc-500 text-center">
                &copy; 2026 Admin Panel
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-y-auto">
            
            <header class="bg-white border-b border-zinc-200 px-6 py-4 flex justify-between items-center">
               <h1 class="text-2xl font-bold text-zinc-900 tracking-tight">Dashboard Utama</h1>
                   <div class="flex items-center gap-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-amber-500/10 border border-amber-500/20 rounded-full text-amber-400 text-xs font-semibold select-none">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                        Status: Administrator
                    </div>
                </div>
            </header>

            <main class="p-6 space-y-6">
                
                <div class="p-6 bg-gradient-to-r from-amber-500/10 via-amber-600/5 to-transparent border border-amber-500/20 rounded-3xl relative overflow-hidden backdrop-blur-md">
                    <h2 class="text-xl font-bold text-white mb-1">Halo, {{ Auth::user()->name }}! 👋</h2>
                    <p class="text-zinc-300 text-sm">Selamat datang di panel administrasi penyewaan kendaraan, Berhati-hati saat berkendara karena keselamatan yang utama.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="p-6 bg-zinc-900/60 border border-zinc-800 rounded-2xl relative overflow-hidden group hover:border-zinc-700/60 transition-all duration-300">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Total Pengguna</p>
                            <p class="text-3xl font-bold text-white tracking-tight mt-1"></p>
                            <span class="text-xs text-green-500 font-semibold flex items-center gap-1 mt-2">
                                <span class="text-zinc-500 font-normal"></span>
                            </span>
                        </div>
                        <div class="absolute right-6 top-6 p-3 bg-zinc-800 text-amber-400 rounded-xl border border-zinc-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>

                    <div class="p-6 bg-zinc-900/60 border border-zinc-800 rounded-2xl relative overflow-hidden group hover:border-zinc-700/60 transition-all duration-300">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Pendapatan</p>
                            <p class="text-3xl font-bold text-white tracking-tight mt-1"></p>
                            <span class="text-xs text-green-500 font-semibold flex items-center gap-1 mt-2">
                                <span class="text-zinc-500 font-normal"></span>
                            </span>
                        </div>
                        <div class="absolute right-6 top-6 p-3 bg-zinc-800 text-amber-400 rounded-xl border border-zinc-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>

                    <div class="p-6 bg-zinc-900/60 border border-zinc-800 rounded-2xl relative overflow-hidden group hover:border-zinc-700/60 transition-all duration-300">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Pesanan Baru</p>
                            <p class="text-3xl font-bold text-white tracking-tight mt-1"></p>
                            <span class="text-xs text-red-500 font-semibold flex items-center gap-1 mt-2">
                                <span class="text-zinc-500 font-normal"></span>
                            </span>
                        </div>
                        <div class="absolute right-6 top-6 p-3 bg-zinc-800 text-amber-400 rounded-xl border border-zinc-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                    </div>

                    <div class="p-6 bg-zinc-900/60 border border-zinc-800 rounded-2xl relative overflow-hidden group hover:border-zinc-700/60 transition-all duration-300">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Tingkat Konversi</p>
                            <p class="text-3xl font-bold text-white tracking-tight mt-1"></p>
                            <span class="text-xs text-green-500 font-semibold flex items-center gap-1 mt-2">
                                <span class="text-zinc-500 font-normal"></span>
                            </span>
                        </div>
                        <div class="absolute right-6 top-6 p-3 bg-zinc-800 text-amber-400 rounded-xl border border-zinc-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-zinc-900/40 border border-zinc-800 rounded-3xl overflow-hidden backdrop-blur-md">
                    <div class="px-6 py-4 border-b border-zinc-800 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-white">Transaksi Terbaru</h3>
                    </div>
                    
                    <div class="flex flex-col items-center justify-center py-12 text-zinc-500">
                        <svg class="w-12 h-12 mb-3 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 12H4M22 6.5h-20M22 17.5h-20"></path>
                        </svg>
                        <p class="text-sm">Belum ada transaksi terbaru saat ini.</p>
                    </div>
                </div>

            </main>
        </div>
    </div>
</x-app-layout>