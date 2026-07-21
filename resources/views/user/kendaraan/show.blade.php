<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Detail Kendaraan') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <a href="{{ route('user.kendaraan.index') }}" class="text-blue-600 hover:underline text-sm">
                ← Kembali ke Daftar Kendaraan
            </a>

            <div class="mt-4 bg-white rounded-xl shadow overflow-hidden">

                <div class="h-64 bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-500">Foto Kendaraan</span>
                </div>

                <div class="p-6">

                    <div class="flex justify-between items-start">
                        <h1 class="text-2xl font-bold text-gray-900">{{ $kendaraan->nama }}</h1>

                        @if($kendaraan->status === 'tersedia')
                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-semibold">Tersedia</span>
                        @else
                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm font-semibold">Disewa</span>
                        @endif
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-4 text-sm text-gray-600">
                        <p><strong>Merk:</strong> {{ $kendaraan->merk }}</p>
                        <p><strong>Plat Nomor:</strong> {{ $kendaraan->plat_nomor }}</p>
                        <p><strong>Tahun:</strong> {{ $kendaraan->tahun }}</p>
                        <p><strong>Harga Sewa:</strong> Rp {{ number_format($kendaraan->harga_sewa, 0, ',', '.') }} / hari</p>
                    </div>

                    <div class="mt-6">
                        @if($kendaraan->status === 'tersedia')
                            <a href="{{ route('user.penyewaan.create') }}"
                               class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded font-semibold">
                                Sewa Sekarang
                            </a>
                        @else
                            <button disabled
                                class="inline-block bg-gray-300 text-gray-500 px-6 py-3 rounded font-semibold cursor-not-allowed">
                                Kendaraan Sedang Disewa
                            </button>
                        @endif
                    </div>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>