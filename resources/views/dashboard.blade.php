<x-app-layout class="font-sans antialiased bg-zinc-950 text-zinc-100 min-h-screen relative overflow-x-hidden selection:bg-amber-500 selection:text-black">
    <x-slot name="header">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="font-bold text-2xl text-black tracking-tight leading-tight">
                {{ __('Dashboard Pelanggan') }}
            </h2>

            <p class="text-sm text-black-400 mt-1">
                Sewa kendaraan impian Anda dengan aman, cepat, dan transparan.
            </p>
        </div>

        <div class="inline-flex items-center gap-2 px-3 py-1 bg-amber-500/10 border border-amber-500/20 rounded-full text-amber-400 text-xs font-semibold select-none self-start sm:self-auto">
            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
            Pelanggan Terverifikasi
        </div>
    </div>
    </x-slot>

    <div class="min-h-screen bg-zinc-950 py-8">
        <div class="px-4 sm:px-6 lg:px-7 max-w-7xl mx-auto space-y-5">
            
            <div class="p-6 bg-gradient-to-r from-amber-500/10 via-amber-600/5 to-transparent border border-amber-500/20 rounded-3xl relative overflow-hidden backdrop-blur-md">
                <div class="absolute right-6 top-1/2 -translate-y-1/2 opacity-10 pointer-events-none hidden md:block">
                    <svg class="w-40 h-40 text-amber-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09 l-.317-5.072a3.375 3.375 0 0 0-3.355-3.167H7.525a3.375 3.375 0 0 0-3.355 3.167l-.317 5.072c-.039.62.469 1.124 1.09 1.124H5.25M16.5 13.5H7.5M16.5 13.5v-3.75m0 3.75h-.375a1.125 1.125 0 0 1-1.125-1.125v-1.5a1.125 1.125 0 0 1 1.125-1.125h.375M7.5 13.5H7.125A1.125 1.125 0 0 0 6 14.625v1.5c0 .621.504 1.125 1.125 1.125H7.5M7.5 13.5V9.75m0 0h.375c.621 0 1.129.504 1.09 1.124v1.5c-.039.62-.469 1.124-1.09 1.124H7.5m0-3.75h8.25m0 0H16.5m-9 0V7.5A2.25 2.25 0 0 1 9.75 5.25h4.5A2.25 2.25 0 0 1 16.5 7.5v2.25"></path>
                    </svg>
                </div>
                <div class="max-w-2xl">
                    <h3 class="text-lg font-bold text-white mb-2">Halo, {{ Auth::user()->name }}!</h3>
                    <p class="text-sm text-zinc-300 leading-relaxed">
                        Mau jalan-jalan tetapi tidak punya kendaraan? Temukan kendaraan terbaik mulai dari motor atau mobil terbaik buat kenyamanan keluarga anda. Dapatkan diskon 10% untuk sewa pertamamu!
                    </p>
                    <div class="mt-4 flex gap-3">
                        <a href="{{ route('daftar-kendaraan.index') }}" class="px-4 py-2 bg-amber-500 text-black hover:bg-amber-400 text-xs font-bold rounded-xl transition-all shadow-[0_4px_15px_rgba(245,158,11,0.25)] active:scale-95">
                            Cari Kendaraan Sekarang
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="p-6 bg-zinc-900/60 border border-zinc-800 rounded-2xl relative overflow-hidden group hover:border-zinc-700/60 transition-all duration-300">
                    <span class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Sedang Disewa</span>
                    <div class="mt-4 flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-white tracking-tight"></span>
                        <span class="text-xs text-zinc-500">Unit Kendaraan</span>
                    </div>
                    <p class="text-xs text-amber-500 mt-2 font-medium"></p>
                </div>

                <div class="p-6 bg-zinc-900/60 border border-zinc-800 rounded-2xl relative overflow-hidden group hover:border-zinc-700/60 transition-all duration-300">
                    <span class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Total Riwayat Sewa</span>
                    <div class="mt-4 flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-white tracking-tight"></span>
                        <span class="text-xs text-zinc-500">Penyewaan</span>
                    </div>
                    <p class="text-xs text-zinc-400 mt-2"></p>
                </div>

                <div class="p-6 bg-zinc-900/60 border border-zinc-800 rounded-2xl relative overflow-hidden group hover:border-zinc-700/60 transition-all duration-300">
                    <span class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Menunggu Pembayaran</span>
                    <div class="mt-4 flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-red-500 tracking-tight"></span>
                        <span class="text-xs text-zinc-500">Tagihan</span>
                    </div>
                    <p class="text-xs text-green-500 mt-2 font-semibold flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12z"></path>
                        </svg>
                    </p>
                </div>

                <div class="p-6 bg-zinc-900/60 border border-zinc-800 rounded-2xl relative overflow-hidden group hover:border-zinc-700/60 transition-all duration-300">
                    <span class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Poin RentApp</span>
                    <div class="mt-4 flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-white tracking-tight"></span>
                        <span class="text-xs text-zinc-500">Points</span>
                    </div>
                    <p class="text-xs text-amber-500 mt-2 hover:underline cursor-pointer"></p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">
                 <div class="lg:col-span-7 bg-zinc-900/40 border border-zinc-800 rounded-3xl p-6 relative overflow-hidden backdrop-blur-md flex flex-col justify-between">
                    <div>
                <div class="flex items-center justify-between border-b border-zinc-800 pb-4 mb-6">
                    <div>
                    <h3 class="text-lg font-bold text-white">Sewa Aktif Anda</h3>
                    <p class="text-xs text-zinc-500">Detail status kendaraan yang sedang Anda sewa saat ini.</p>
                </div>
            </div>

            <div class="flex flex-col items-center justify-center text-center py-12 px-6 border border-dashed border-zinc-800 rounded-2xl bg-zinc-950/40 space-y-5">
                <div class="p-2 bg-zinc-900 border border-zinc-800 text-zinc-500 rounded-xl">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-white mb-2">Tidak Ada Sewa Aktif</h4>
                    <p class="text-xs text-zinc-500 max-w-sm leading-relaxed mx-auto">
                        Saat ini Anda tidak memiliki kendaraan yang sedang disewa. Jelajahi armada kami untuk mulai menyewa.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-5 space-y-6">
        <div class="bg-zinc-900/40 border border-zinc-800 rounded-3xl p-6 shadow-2xl relative overflow-hidden backdrop-blur-md">
            <div class="flex items-center justify-between border-b border-zinc-800 pb-3 mb-5">
                <h3 class="text-sm font-bold uppercase tracking-wider text-zinc-400">Rekomendasi Kendaraan</h3>
                <a href="{{ route('daftar-kendaraan.index') }}" class="text-xs text-amber-500 hover:text-amber-400 font-semibold transition-colors">
                    Lihat Semua
                </a>
            </div>
            
            <div class="space-y-4">
                <div class="p-3 bg-zinc-950/60 border border-zinc-800 hover:border-zinc-700 rounded-xl flex items-center justify-between group transition-all duration-300">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-zinc-900 border border-zinc-800 flex items-center justify-center text-amber-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.3 12.3c.3.3.6.8.6 1.3 0 1.1-.9 2-2 2h-.8v1.6H12v-1.6h-.8c-1.1 0-2-.9-2-2 0-.5.2-1 .6-1.3"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold text-white"></h4>
                            <p class="text-[10px] text-zinc-500"></p>
                        </div>
                    </div>
                    <a href="{{ route('penyewaan-kendaraan.index') }}" class="px-3 py-1.5 bg-amber-500/10 border border-amber-500/20 text-amber-500 hover:bg-amber-500 hover:text-black rounded-lg text-[10px] font-bold transition-all">
                        Sewa
                    </a>
                </div>
                
                <div class="p-3 bg-zinc-950/60 border border-zinc-800 hover:border-zinc-700 rounded-xl flex items-center justify-between group transition-all duration-300">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-zinc-900 border border-zinc-800 flex items-center justify-center text-amber-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09l-.317-5.072a3.375 3.375 0 0 0-3.355-3.167H7.525a3.375 3.375 0 0 0-3.355 3.167l-.317 5.072c-.039.62.469 1.124 1.09 1.124H5.25M16.5 13.5H7.5M16.5 13.5v-3.75m0 3.75h-.375a1.125 1.125 0 0 1-1.125-1.125v-1.5a1.125 1.125 0 0 1 1.125-1.125h.375M7.5 13.5H7.125A1.125 1.125 0 0 0 6 14.625v1.5c0 .621.504 1.125 1.125 1.125H7.5M7.5 13.5V9.75m0 0h.375c.621 0 1.129.504 1.09 1.124v1.5c-.039.62-.469 1.124-1.09 1.124H7.5m0-3.75h8.25m0 0H16.5m-9 0V7.5A2.25 2.25 0 0 1 9.75 5.25h4.5A2.25 2.25 0 0 1 16.5 7.5v2.25"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold text-white"></h4>
                            <p class="text-[10px] text-zinc-500"></p>
                        </div>
                    </div>
                    <a href="{{ route('penyewaan-kendaraan.index') }}" class="px-3 py-1.5 bg-amber-500/10 border border-amber-500/20 text-amber-500 hover:bg-amber-500 hover:text-black rounded-lg text-[10px] font-bold transition-all">
                        Sewa
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-zinc-900/40 border border-zinc-800 rounded-3xl p-6 backdrop-blur-md">
            <h3 class="text-sm font-bold uppercase tracking-wider text-zinc-400 mb-4 border-b border-zinc-800 pb-2">Bantuan & Hubungi Kami</h3>
            <p class="text-xs text-zinc-400 leading-relaxed mb-4">
                Mengalami kendala saat berkendara atau ingin mengajukan perpanjangan durasi sewa? Layanan CS kami online 24/7 untuk membantu Anda.
            </p>
            <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center justify-center gap-2 w-full py-3 bg-zinc-950/60 border border-zinc-800 hover:border-amber-500/30 text-zinc-300 hover:text-amber-500 text-xs font-bold rounded-2xl transition-all">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.59-4.846c1.62.962 3.21 1.493 4.887 1.495 5.518.002 10.005-4.486 10.008-10.012.002-2.677-1.037-5.195-2.931-7.091-1.895-1.895-4.417-2.934-7.097-2.935-5.523 0-10.012 4.488-10.015 10.015-.001 1.743.459 3.447 1.332 4.965l-.982 3.585 3.684-.969zm13.111-6.196c-.328-.163-1.936-.955-2.238-1.066-.301-.11-.52-.163-.738.163-.219.327-.847 1.066-1.039 1.284-.191.218-.383.245-.71.082-.328-.164-1.383-.509-2.636-1.626-.975-.87-1.632-1.944-1.823-2.271-.191-.327-.02-.504.143-.667.147-.146.328-.382.492-.573.164-.191.219-.327.328-.545.109-.219.055-.409-.028-.573-.082-.164-.738-1.782-1.011-2.44-.267-.643-.539-.556-.738-.566-.19-.01-.41-.01-.628-.01-.219 0-.575.082-.876.409-.301.327-1.148 1.121-1.148 2.731s1.176 3.166 1.34 3.385c.164.218 2.313 3.53 5.603 4.95.782.337 1.393.539 1.87.691.785.25 1.5.215 2.065.13.629-.094 1.936-.792 2.21-1.556.273-.764.273-1.419.191-1.556-.081-.137-.301-.219-.629-.382z"/>
                </svg>
                Hubungi WhatsApp CS
            </a>
        </div>
    </div>
</div>

            </div>
        </div>
    </div>
</x-app-layout>