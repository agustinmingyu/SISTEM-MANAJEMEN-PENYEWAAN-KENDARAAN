@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                Daftar Kendaraan
            </h1>
            <p class="text-gray-500">
                Pilih kendaraan yang ingin Anda sewa.
            </p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-5 p-4 rounded bg-green-100 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @forelse($kendaraans as $kendaraan)

        <div class="bg-white rounded-xl shadow hover:shadow-lg transition">

            <div class="h-48 bg-gray-200 flex items-center justify-center">
                <span class="text-gray-500">
                    Foto Kendaraan
                </span>
            </div>

            <div class="p-5">

                <h2 class="text-xl font-bold">
                    {{ $kendaraan->nama }}
                </h2>

                <div class="mt-3 space-y-2 text-sm text-gray-600">

                    <p>
                        <strong>Merk :</strong>
                        {{ $kendaraan->merk }}
                    </p>

                    <p>
                        <strong>Plat :</strong>
                        {{ $kendaraan->plat_nomor }}
                    </p>

                    <p>
                        <strong>Tahun :</strong>
                        {{ $kendaraan->tahun }}
                    </p>

                    <p>
                        <strong>Harga :</strong>

                        Rp {{ number_format($kendaraan->harga_sewa,0,',','.') }}

                        / hari
                    </p>

                    <p>
                        <strong>Status :</strong>

                        <span class="text-green-600 font-semibold">
                            {{ ucfirst($kendaraan->status) }}
                        </span>

                    </p>

                </div>

                <div class="mt-5">

                    <a href="{{ route('user.kendaraan.show',$kendaraan->id) }}"
                       class="w-full block text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded">

                        Lihat Detail

                    </a>

                </div>

            </div>

        </div>

        @empty

        <div class="col-span-3 text-center text-gray-500">

            Belum ada kendaraan tersedia.

        </div>

        @endforelse

    </div>

</div>
@endsection