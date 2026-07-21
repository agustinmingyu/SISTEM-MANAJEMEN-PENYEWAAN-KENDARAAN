<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Pembayaran Penyewaan') }}
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

            @if(session('error'))
                <div class="mb-4 rounded bg-red-500 text-white p-4">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded bg-red-500 text-white p-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6">

                <div class="flex justify-between items-start mb-6">
                    <h3 class="text-xl font-bold">Penyewaan #{{ $penyewaan->id }}</h3>

                    @php
                        $statusColor = match($pembayaran->status) {
                            'Paid' => 'bg-green-100 text-green-700',
                            'Failed' => 'bg-red-100 text-red-700',
                            default => 'bg-yellow-100 text-yellow-700',
                        };
                    @endphp

                    <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $statusColor }}">
                        {{ $pembayaran->status }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm text-gray-700 mb-6">
                    <p><strong>Kendaraan:</strong> {{ $penyewaan->kendaraan->nama ?? '-' }}</p>
                    <p><strong>Merk:</strong> {{ $penyewaan->kendaraan->merk ?? '-' }}</p>
                    <p><strong>Tanggal Sewa:</strong> {{ $penyewaan->tanggal_sewa }}</p>
                    <p><strong>Lama Sewa:</strong> {{ $penyewaan->lama_sewa }} Hari</p>
                    <p class="col-span-2"><strong>Total yang Harus Dibayar:</strong>
                        Rp {{ number_format($pembayaran->amount, 0, ',', '.') }}
                    </p>
                </div>

                @if($pembayaran->status === 'Paid')
                    <div class="border-t pt-6">
                        <p class="text-green-700 font-medium mb-4">
                            Pembayaran ini sudah berhasil diproses pada
                            {{ optional($pembayaran->paid_at)->format('d M Y H:i') }}.
                        </p>
                        <a href="{{ route('user.penyewaan.show', $penyewaan) }}"
                           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                            Lihat Detail Penyewaan
                        </a>
                    </div>
                @else
                    <form method="POST" action="{{ route('user.penyewaan.prosesPembayaran', $penyewaan) }}" class="border-t pt-6">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Metode Pembayaran
                            </label>
                            <input type="text"
                                   value="{{ $pembayaran->payment_method ?? 'Saldo' }}"
                                   disabled
                                   class="w-full rounded border-gray-300 bg-gray-100 text-gray-600">
                        </div>

                        <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded font-semibold">
                            Bayar Sekarang
                        </button>

                        <a href="{{ route('user.penyewaan.show', $penyewaan) }}"
                           class="ml-3 text-gray-600 hover:underline">
                            Batal
                        </a>
                    </form>
                @endif

            </div>

        </div>
    </div>

</x-app-layout>