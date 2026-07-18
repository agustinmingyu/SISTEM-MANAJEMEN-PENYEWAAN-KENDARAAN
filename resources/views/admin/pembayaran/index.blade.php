@extends('layouts.admin')

@section('title', 'Pembayaran')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold">Pembayaran</h1>
            <p class="text-zinc-400">Kelola transaksi pembayaran penyewaan.</p>
        </div>
        <a href="{{ route('admin.riwayat-pembayaran.index') }}" class="bg-zinc-700 text-white px-4 py-2 rounded-lg hover:bg-zinc-600">
            Lihat Riwayat Pembayaran
        </a>
    </div>

    <div class="bg-zinc-900 rounded-3xl border border-zinc-800 p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h3 class="text-xl font-bold text-white">Ringkasan Pembayaran</h3>
                <p class="text-sm text-zinc-400">Total pendapatan dari pembayaran yang sudah berstatus Paid.</p>
            </div>
            <div class="rounded-3xl border border-zinc-700 bg-zinc-950 p-4 text-right">
                <p class="text-xs uppercase tracking-wider text-zinc-500">Total Pendapatan</p>
                <p class="text-3xl font-bold text-amber-500">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

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
                    <th class="p-4">Dibayar</th>
                    <th class="p-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-800">
                @forelse($pembayarans as $pembayaran)
                    <tr class="hover:bg-zinc-800 transition">
                        <td class="p-4">{{ $loop->iteration }}</td>
                        <td class="p-4">{{ $pembayaran->user?->name ?? '-' }}</td>
                        <td class="p-4">{{ $pembayaran->penyewaan?->kendaraan?->nama ?? '-' }}</td>
                        <td class="p-4">Rp {{ number_format($pembayaran->amount, 0, ',', '.') }}</td>
                        <td class="p-4">{{ $pembayaran->payment_method ?? '-' }}</td>
                        <td class="p-4">{{ $pembayaran->status }}</td>
                        <td class="p-4">{{ $pembayaran->paid_at?->format('Y-m-d H:i') ?? '-' }}</td>
                        <td class="p-4">
                            <a href="{{ route('admin.pembayaran.show', $pembayaran) }}" class="text-amber-400 hover:text-amber-300">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-6 text-center text-zinc-500">Belum ada data pembayaran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
