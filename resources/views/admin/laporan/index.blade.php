@extends('layouts.admin')

@section('title', 'Laporan')

@section('content')

<div class="space-y-6">

    <div>
        <h1 class="text-3xl font-bold text-white">Laporan</h1>
        <p class="text-zinc-400">Ringkasan performa penyewaan dan pembayaran, lengkap dengan diagram.</p>
    </div>

    <form method="GET" class="bg-zinc-900 border border-zinc-800 rounded-2xl p-4 flex flex-wrap items-center gap-3">
        <label class="text-sm text-zinc-400">Dari</label>
        <input type="date" name="dari" value="{{ $dari->format('Y-m-d') }}"
               class="border border-zinc-700 bg-zinc-950 text-white rounded p-2" />

        <label class="text-sm text-zinc-400">Sampai</label>
        <input type="date" name="sampai" value="{{ $sampai->format('Y-m-d') }}"
               class="border border-zinc-700 bg-zinc-950 text-white rounded p-2" />

        <button class="bg-amber-500 text-black px-4 py-2 rounded font-semibold hover:bg-amber-400">
            Terapkan
        </button>

        <a href="{{ route('admin.laporan.index') }}" class="text-sm text-zinc-400 hover:text-white">
            Reset ke 6 bulan terakhir
        </a>
    </form>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <div class="p-6 bg-zinc-900/60 border border-zinc-800 rounded-2xl">
            <p class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Total Pendapatan</p>
            <p class="text-2xl font-bold text-white mt-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
        </div>

        <div class="p-6 bg-zinc-900/60 border border-zinc-800 rounded-2xl">
            <p class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Total Penyewaan</p>
            <p class="text-2xl font-bold text-white mt-1">{{ $totalPenyewaan }}</p>
        </div>

        <div class="p-6 bg-zinc-900/60 border border-zinc-800 rounded-2xl">
            <p class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Penyewaan Selesai</p>
            <p class="text-2xl font-bold text-white mt-1">{{ $penyewaanSelesai }}</p>
        </div>

        <div class="p-6 bg-zinc-900/60 border border-zinc-800 rounded-2xl">
            <p class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Rata-rata / Transaksi</p>
            <p class="text-2xl font-bold text-white mt-1">Rp {{ number_format($rataRataTransaksi ?? 0, 0, ',', '.') }}</p>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 bg-zinc-900 rounded-2xl border border-zinc-800 p-6">
            <h3 class="text-lg font-bold text-white mb-1">Tren Pendapatan</h3>
            <p class="text-sm text-zinc-500 mb-4">Total pembayaran berstatus Paid per bulan pada rentang terpilih.</p>
            <canvas id="chartPendapatan" height="220"></canvas>
        </div>

        <div class="bg-zinc-900 rounded-2xl border border-zinc-800 p-6">
            <h3 class="text-lg font-bold text-white mb-1">Status Penyewaan</h3>
            <p class="text-sm text-zinc-500 mb-4">Distribusi pada rentang terpilih.</p>
            <canvas id="chartStatus" height="220"></canvas>
        </div>

        <div class="lg:col-span-3 bg-zinc-900 rounded-2xl border border-zinc-800 p-6">
            <h3 class="text-lg font-bold text-white mb-1">Kendaraan Paling Sering Disewa</h3>
            <p class="text-sm text-zinc-500 mb-4">5 kendaraan teratas pada rentang terpilih.</p>
            <canvas id="chartKendaraan" height="120"></canvas>
        </div>

    </div>

</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.4/chart.umd.min.js"></script>
<script>
    const zincGrid = 'rgba(255,255,255,0.06)';
    const zincText = '#a1a1aa';

    Chart.defaults.color = zincText;
    Chart.defaults.font.family = 'inherit';

    // 1. Tren Pendapatan
    new Chart(document.getElementById('chartPendapatan'), {
        type: 'line',
        data: {
            labels: @json($labelPendapatan),
            datasets: [{
                label: 'Pendapatan',
                data: @json($dataPendapatan),
                borderColor: '#ef4444',
                backgroundColor: 'rgba(239, 68, 68, 0.15)',
                fill: true,
                tension: 0.3,
                pointBackgroundColor: '#ef4444',
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

    // 2. Status Penyewaan
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
            plugins: { legend: { position: 'bottom' } }
        }
    });

    // 3. Kendaraan Paling Sering Disewa
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