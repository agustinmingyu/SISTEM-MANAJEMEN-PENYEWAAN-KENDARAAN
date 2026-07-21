@extends('layouts.admin')

@section('title', 'Riwayat Pembayaran')

@section('content')
<div class="container mx-auto p-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-white">Riwayat Pembayaran</h1>
            <p class="text-zinc-400">Arsip seluruh transaksi pembayaran yang pernah terjadi.</p>
        </div>
        <a href="{{ route('admin.pembayaran.index') }}" class="bg-zinc-700 text-white px-4 py-2 rounded-lg hover:bg-zinc-600">
            Kembali ke Pembayaran
        </a>
    </div>

    <div class="bg-zinc-900 rounded-3xl border border-zinc-800 p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h3 class="text-xl font-bold text-white">Total Pendapatan (sesuai filter)</h3>
                <p class="text-sm text-zinc-400">Total dari transaksi berstatus Paid pada rentang yang dipilih.</p>
            </div>
            <div class="rounded-3xl border border-zinc-700 bg-zinc-950 p-4 text-right">
                <p class="text-xs uppercase tracking-wider text-zinc-500">Total Pendapatan</p>
                <p class="text-3xl font-bold text-amber-500">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <form method="GET" class="mb-4 flex gap-2 items-center flex-wrap bg-zinc-900 border border-zinc-800 rounded-2xl p-4">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari user atau kendaraan"
               class="border border-zinc-700 bg-zinc-950 text-white rounded p-2" />

        <select name="status" class="border border-zinc-700 bg-zinc-950 text-white rounded p-2">
            <option value="">-- Semua status --</option>
            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Paid" {{ request('status') == 'Paid' ? 'selected' : '' }}>Paid</option>
            <option value="Failed" {{ request('status') == 'Failed' ? 'selected' : '' }}>Failed</option>
        </select>

        <input type="date" name="dari" value="{{ request('dari') }}"
               class="border border-zinc-700 bg-zinc-950 text-white rounded p-2" />
        <span class="text-zinc-400">s/d</span>
        <input type="date" name="sampai" value="{{ request('sampai') }}"
               class="border border-zinc-700 bg-zinc-950 text-white rounded p-2" />

        <button class="bg-amber-500 text-black px-3 py-2 rounded font-semibold hover:bg-amber-400">Filter</button>

        @if(request('q') || request('status') || request('dari') || request('sampai'))
            <a href="{{ route('admin.riwayat-pembayaran.index') }}" class="text-sm text-zinc-400 hover:text-white">Reset</a>
        @endif

        <a href="?{{ http_build_query(array_merge(request()->all(), ['export' => 'csv'])) }}"
           class="ml-auto text-sm text-blue-400 hover:text-blue-300">
            Export CSV
        </a>
    </form>

    <div class="bg-zinc-900 rounded-3xl border border-zinc-800 overflow-hidden shadow">
        <table class="w-full text-left">
            <thead class="bg-zinc-800 text-zinc-300">
                <tr>
                    <th class="p-4">No</th>
                    <th class="p-4">Penyewa</th>
                    <th class="p-4">Kendaraan</th>
                    <th class="p-4">Jumlah</th>
                    <th class="p-4">Metode</th>
                    <th class="p-4">Status</th>
                    <th class="p-4">Dibayar Pada</th>
                    <th class="p-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-800">
                @forelse($pembayarans as $pembayaran)
                    <tr class="hover:bg-zinc-800 transition">
                        <td class="p-4">{{ $loop->iteration + ($pembayarans->currentPage() - 1) * $pembayarans->perPage() }}</td>
                        <td class="p-4">{{ $pembayaran->user?->name ?? '-' }}</td>
                        <td class="p-4">{{ $pembayaran->penyewaan?->kendaraan?->nama ?? '-' }}</td>
                        <td class="p-4">Rp {{ number_format($pembayaran->amount, 0, ',', '.') }}</td>
                        <td class="p-4">{{ $pembayaran->payment_method ?? '-' }}</td>
                        <td class="p-4">
                            @php
                                $statusColor = match($pembayaran->status) {
                                    'Paid' => 'bg-green-100 text-green-700',
                                    'Failed' => 'bg-red-100 text-red-700',
                                    default => 'bg-yellow-100 text-yellow-700',
                                };
                            @endphp
                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                                {{ $pembayaran->status }}
                            </span>
                        </td>
                        <td class="p-4">{{ $pembayaran->paid_at?->format('d M Y H:i') ?? '-' }}</td>
                        <td class="p-4">
                            <a href="{{ route('admin.pembayaran.show', $pembayaran) }}" class="text-amber-400 hover:text-amber-300">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-6 text-center text-zinc-500">
                            Tidak ada riwayat pembayaran yang cocok dengan filter.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $pembayarans->links() }}
    </div>

</div>
@endsection