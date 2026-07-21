<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Riwayat Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-bold">Total Pengeluaran (sesuai filter)</h3>
                        <p class="text-sm text-gray-500">Total dari transaksi yang sudah dibayar (Paid).</p>
                    </div>
                    <div class="rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-right">
                        <p class="text-xs uppercase tracking-wider text-gray-400">Total</p>
                        <p class="text-2xl font-bold text-blue-600">
                            Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg p-6">

                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-xl font-bold">Riwayat Transaksi Saya</h3>
                    <a href="{{ route('user.penyewaan.index') }}" class="text-sm text-blue-600 hover:underline">
                        Kelola Penyewaan
                    </a>
                </div>

                <form method="GET" class="mb-4 flex gap-2 items-center flex-wrap bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama kendaraan"
                           class="border border-gray-300 rounded p-2" />

                    <select name="status" class="border border-gray-300 rounded p-2">
                        <option value="">-- Semua status --</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>

                    <input type="date" name="dari" value="{{ request('dari') }}"
                           class="border border-gray-300 rounded p-2" />
                    <span class="text-gray-500">s/d</span>
                    <input type="date" name="sampai" value="{{ request('sampai') }}"
                           class="border border-gray-300 rounded p-2" />

                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded font-semibold">
                        Filter
                    </button>

                    @if(request('q') || request('status') || request('dari') || request('sampai'))
                        <a href="{{ route('user.riwayat.index') }}" class="text-sm text-gray-500 hover:text-gray-800">
                            Reset
                        </a>
                    @endif
                </form>

                <table class="w-full border border-gray-300">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border p-2">No</th>
                            <th class="border p-2">Kendaraan</th>
                            <th class="border p-2">Tanggal Sewa</th>
                            <th class="border p-2">Lama</th>
                            <th class="border p-2">Total</th>
                            <th class="border p-2">Status Transaksi</th>
                            <th class="border p-2">Status Pembayaran</th>
                            <th class="border p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penyewaans as $penyewaan)
                            <tr>
                                <td class="border p-2 text-center">
                                    {{ $loop->iteration + ($penyewaans->currentPage() - 1) * $penyewaans->perPage() }}
                                </td>

                                <td class="border p-2">{{ $penyewaan->kendaraan->nama ?? '-' }}</td>

                                <td class="border p-2">{{ $penyewaan->tanggal_sewa }}</td>

                                <td class="border p-2">{{ $penyewaan->lama_sewa }} Hari</td>

                                <td class="border p-2">
                                    Rp {{ number_format($penyewaan->total_harga, 0, ',', '.') }}
                                </td>

                                <td class="border p-2">
                                    @php
                                        $statusColor = match($penyewaan->status) {
                                            'Disetujui' => 'bg-green-100 text-green-700',
                                            'Ditolak' => 'bg-red-100 text-red-700',
                                            'Selesai' => 'bg-blue-100 text-blue-700',
                                            default => 'bg-yellow-100 text-yellow-700',
                                        };
                                    @endphp
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                                        {{ $penyewaan->status }}
                                    </span>
                                </td>

                                <td class="border p-2">
                                    @php
                                        $pembayaranStatus = $penyewaan->pembayaran->status ?? '-';
                                        $bayarColor = match($pembayaranStatus) {
                                            'Paid' => 'bg-green-100 text-green-700',
                                            'Failed' => 'bg-red-100 text-red-700',
                                            'Pending' => 'bg-yellow-100 text-yellow-700',
                                            default => 'bg-gray-100 text-gray-500',
                                        };
                                    @endphp
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $bayarColor }}">
                                        {{ $pembayaranStatus }}
                                    </span>
                                </td>

                                <td class="border p-2 text-center">
                                    <a href="{{ route('user.penyewaan.show', $penyewaan->id) }}"
                                       class="bg-green-600 text-white px-2 py-1 rounded">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="border p-4 text-center">
                                    Tidak ada riwayat transaksi yang cocok dengan filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $penyewaans->links() }}
                </div>

            </div>

        </div>
    </div>

</x-app-layout>