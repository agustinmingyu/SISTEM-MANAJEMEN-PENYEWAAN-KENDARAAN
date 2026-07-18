<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">{{ __('Pembayaran') }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-xl font-bold">Ringkasan Pembayaran</h3>
                        <p class="text-sm text-zinc-500">Daftar transaksi pembayaran penyewaan yang sudah dicatat.</p>
                    </div>
                    <div class="rounded-3xl border border-zinc-300 bg-zinc-950 p-4 text-right">
                        <p class="text-xs uppercase tracking-wider text-zinc-400">Total Pendapatan</p>
                        <p class="text-3xl font-bold text-amber-500">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <table class="w-full border border-gray-300">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border p-2">No</th>
                            <th class="border p-2">Penyewa</th>
                            <th class="border p-2">Kendaraan</th>
                            <th class="border p-2">Jumlah</th>
                            <th class="border p-2">Metode</th>
                            <th class="border p-2">Status</th>
                            <th class="border p-2">Dibayar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pembayarans as $pembayaran)
                            <tr>
                                <td class="border p-2 text-center">{{ $loop->iteration }}</td>
                                <td class="border p-2">{{ $pembayaran->user?->name ?? '-' }}</td>
                                <td class="border p-2">{{ $pembayaran->penyewaan?->kendaraan?->nama ?? '-' }}</td>
                                <td class="border p-2">Rp {{ number_format($pembayaran->amount, 0, ',', '.') }}</td>
                                <td class="border p-2">{{ $pembayaran->payment_method ?? '-' }}</td>
                                <td class="border p-2">{{ $pembayaran->status }}</td>
                                <td class="border p-2">{{ $pembayaran->paid_at?->format('Y-m-d H:i') ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="border p-4 text-center">Belum ada data pembayaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>
