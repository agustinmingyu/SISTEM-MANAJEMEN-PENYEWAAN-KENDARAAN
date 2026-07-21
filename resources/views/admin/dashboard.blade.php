@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="space-y-6">

    <div class="p-6 bg-gradient-to-r from-amber-500/10 via-amber-600/5 to-transparent border border-amber-500/20 rounded-3xl relative overflow-hidden backdrop-blur-md">
        <h2 class="text-xl font-bold text-white mb-1">Halo, {{ Auth::user()->name }}! 👋</h2>
        <p class="text-zinc-300 text-sm">Selamat datang di panel administrasi penyewaan kendaraan. Berhati-hati saat berkendara karena keselamatan yang utama.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <a href="{{ route('admin.users.index') }}" class="block p-6 bg-zinc-900/60 border border-zinc-800 rounded-2xl relative overflow-hidden group hover:border-zinc-700/60 transition-all duration-300">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Total Pengguna</p>
                <p class="text-3xl font-bold text-white tracking-tight mt-1">{{ $totalUsers ?? \App\Models\User::count() }}</p>
            </div>
            <div class="absolute right-6 top-6 p-3 bg-zinc-800 text-amber-400 rounded-xl border border-zinc-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </a>

        <a href="{{ route('admin.pembayaran.index') }}" class="block p-6 bg-zinc-900/60 border border-zinc-800 rounded-2xl relative overflow-hidden group hover:border-zinc-700/60 transition-all duration-300">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Pendapatan</p>
                <p class="text-3xl font-bold text-white tracking-tight mt-1">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="absolute right-6 top-6 p-3 bg-zinc-800 text-amber-400 rounded-xl border border-zinc-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </a>

        <a href="{{ route('admin.penyewaan.index', ['status' => 'Pending']) }}" class="block p-6 bg-zinc-900/60 border border-zinc-800 rounded-2xl relative overflow-hidden group hover:border-zinc-700/60 transition-all duration-300">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Pesanan Baru (Pending)</p>
                <p class="text-3xl font-bold text-white tracking-tight mt-1">{{ $pesananPending ?? 0 }}</p>
            </div>
            <div class="absolute right-6 top-6 p-3 bg-zinc-800 text-amber-400 rounded-xl border border-zinc-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
        </a>

        <a href="{{ route('admin.kendaraan.index') }}" class="block p-6 bg-zinc-900/60 border border-zinc-800 rounded-2xl relative overflow-hidden group hover:border-zinc-700/60 transition-all duration-300">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Kendaraan Tersedia</p>
                <p class="text-3xl font-bold text-white tracking-tight mt-1">{{ $kendaraanTersedia ?? 0 }}</p>
            </div>
            <div class="absolute right-6 top-6 p-3 bg-zinc-800 text-amber-400 rounded-xl border border-zinc-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </a>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 bg-zinc-900/40 border border-zinc-800 rounded-3xl p-6 backdrop-blur-md">
            <h3 class="text-lg font-bold text-white mb-1">Pendapatan 6 Bulan Terakhir</h3>
            <p class="text-sm text-zinc-500 mb-4">Total pembayaran berstatus Paid per bulan.</p>
            <canvas id="chartPendapatan" height="220"></canvas>
        </div>

        <div class="bg-zinc-900/40 border border-zinc-800 rounded-3xl p-6 backdrop-blur-md">
            <h3 class="text-lg font-bold text-white mb-1">Status Penyewaan</h3>
            <p class="text-sm text-zinc-500 mb-4">Distribusi seluruh penyewaan.</p>
            <canvas id="chartStatus" height="220"></canvas>
        </div>

        <div class="lg:col-span-3 bg-zinc-900/40 border border-zinc-800 rounded-3xl p-6 backdrop-blur-md">
            <h3 class="text-lg font-bold text-white mb-1">Kendaraan Paling Sering Disewa</h3>
            <p class="text-sm text-zinc-500 mb-4">5 kendaraan dengan jumlah penyewaan terbanyak.</p>
            <canvas id="chartKendaraan" height="120"></canvas>
        </div>

    </div>

    <div class="bg-zinc-900/40 border border-zinc-800 rounded-3xl overflow-hidden backdrop-blur-md">
        <div class="px-6 py-4 border-b border-zinc-800 flex justify-between items-center">
            <h3 class="text-lg font-bold text-white">Transaksi Terbaru</h3>
            <a href="{{ route('admin.pembayaran.index') }}" class="text-sm text-amber-400 hover:text-amber-300">Lihat semua</a>
        </div>

        @if(($transaksiTerbaru ?? collect())->isEmpty())
            <div class="flex flex-col items-center justify-center py-12 text-zinc-500">
                <svg class="w-12 h-12 mb-3 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 12H4M22 6.5h-20M22 17.5h-20"></path>
                </svg>
                <p class="text-sm">Belum ada transaksi terbaru saat ini.</p>
            </div>
        @else
            <div class="divide-y divide-zinc-800">
                @foreach($transaksiTerbaru as $trx)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-zinc-800/50 transition">
                        <div>
                            <p class="text-white font-semibold">{{ $trx->user?->name ?? '-' }}</p>
                            <p class="text-sm text-zinc-500">{{ $trx->penyewaan?->kendaraan?->nama ?? '-' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-amber-400 font-semibold">Rp {{ number_format($trx->amount, 0, ',', '.') }}</p>
                            <p class="text-xs text-zinc-500">{{ $trx->status }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.4/chart.umd.min.js"></script>
<script>
    const zincGrid = 'rgba(255,255,255,0.06)';
    const zincText = '#a1a1aa';

    Chart.defaults.color = zincText;
    Chart.defaults.font.family = 'inherit';

    // 1. Grafik Pendapatan per Bulan
    new Chart(document.getElementById('chartPendapatan'), {
        type: 'bar',
        data: {
            labels: @json($labelPendapatan),
            datasets: [{
                label: 'Pendapatan',
                data: @json($dataPendapatan),
                backgroundColor: 'rgba(239, 68, 68, 0.6)',
                borderColor: '#ef4444',
                borderWidth: 1,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: (ctx) => 'Rp ' + Number(ctx.parsed.y).toLocaleString('id-ID')
                    }
                }
            },
            scales: {
                x: { grid: { display: false } },
                y: {
                    grid: { color: zincGrid },
                    ticks: {
                        callback: (value) => 'Rp ' + Number(value).toLocaleString('id-ID')
                    }
                }
            }
        }
    });

    // 2. Diagram Distribusi Status Penyewaan
    new Chart(document.getElementById('chartStatus'), {
        type: 'doughnut',
        data: {
            labels: @json($labelStatus),
            datasets: [{
                data: @json($dataStatus),
                backgroundColor: ['#ef4444', '#dc2626', '#f87171', '#b91c1c', '#fca5a5'],
                borderColor: '#18181b',
                borderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // 3. Diagram Kendaraan Paling Sering Disewa
    new Chart(document.getElementById('chartKendaraan'), {
        type: 'bar',
        data: {
            labels: @json($labelKendaraan),
            datasets: [{
                label: 'Jumlah Penyewaan',
                data: @json($dataKendaraan),
                backgroundColor: 'rgba(239, 68, 68, 0.6)',
                borderColor: '#ef4444',
                borderWidth: 1,
                borderRadius: 6,
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { color: zincGrid }, ticks: { precision: 0 } },
                y: { grid: { display: false } }
            }
        }
    });
</script>
@endpush

@endsection