<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Detail Penyewaan') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 rounded bg-green-500 text-white p-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('info'))
                <div class="mb-4 rounded bg-blue-500 text-white p-4">
                    {{ session('info') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6">

                <div class="flex justify-between items-start mb-6">
                    <h3 class="text-xl font-bold">Penyewaan #{{ $penyewaan->id }}</h3>

                    @php
                        $statusColor = match($penyewaan->status) {
                            'Disetujui' => 'bg-green-100 text-green-700',
                            'Ditolak' => 'bg-red-100 text-red-700',
                            'Selesai' => 'bg-gray-200 text-gray-700',
                            default => 'bg-yellow-100 text-yellow-700',
                        };
                    @endphp

                    <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $statusColor }}">
                        {{ $penyewaan->status }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">
                    <p><strong>Kendaraan:</strong> {{ $penyewaan->kendaraan->nama ?? '-' }}</p>
                    <p><strong>Merk:</strong> {{ $penyewaan->kendaraan->merk ?? '-' }}</p>
                    <p><strong>Tanggal Sewa:</strong> {{ $penyewaan->tanggal_sewa }}</p>
                    <p><strong>Lama Sewa:</strong> {{ $penyewaan->lama_sewa }} Hari</p>
                    <p class="col-span-2"><strong>Total Harga:</strong> Rp {{ number_format($penyewaan->total_harga, 0, ',', '.') }}</p>
                </div>

                @if($penyewaan->pembayaran)
                    <div class="mt-6 pt-6 border-t">
                        <h4 class="font-semibold mb-3">Informasi Pembayaran</h4>
                        <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">
                            <p><strong>Status:</strong> {{ $penyewaan->pembayaran->status }}</p>
                            <p><strong>Metode:</strong> {{ $penyewaan->pembayaran->payment_method ?? '-' }}</p>
                            <p><strong>Jumlah:</strong> Rp {{ number_format($penyewaan->pembayaran->amount, 0, ',', '.') }}</p>
                            <p><strong>Dibayar Pada:</strong> {{ optional($penyewaan->pembayaran->paid_at)->format('d M Y H:i') ?? '-' }}</p>
                        </div>
                    </div>
                @endif

               <div class="mt-8 flex gap-3">
    <a href="{{ route('user.penyewaan.index') }}"
       class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
        ← Kembali
    </a>

    @if($penyewaan->pembayaran)
        <a href="{{ route('user.penyewaan.invoice', $penyewaan->id) }}" target="_blank"
           class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded">
            🖨️ Cetak Invoice
        </a>
    @endif

    @if($penyewaan->status === 'Pending')
        {{-- tombol edit yang sudah ada, biarkan tetap --}}
                </div>

            </div>

        </div>
    </div>

</x-app-layout>