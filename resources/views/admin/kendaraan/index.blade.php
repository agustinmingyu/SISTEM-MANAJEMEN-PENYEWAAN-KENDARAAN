@extends('layouts.admin')

@section('title', 'Data Kendaraan')

@section('content')

<div class="space-y-6">

    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white">
                Data Kendaraan
            </h1>
            <p class="text-zinc-400">
                Kelola seluruh data kendaraan yang tersedia.
            </p>
        </div>

        <a href="{{ route('admin.kendaraan.create') }}"
            class="bg-amber-500 hover:bg-amber-600 text-black font-semibold px-5 py-3 rounded-xl transition">
            + Tambah Kendaraan
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-500/20 border border-green-500 text-green-300 p-4 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-zinc-900 rounded-2xl border border-zinc-800 overflow-hidden">

    <table class="w-full">

        <thead class="bg-zinc-800 text-zinc-300">

            <tr>

                <th class="p-4 text-left">No</th>
                <th class="p-4 text-left">Nama</th>
                <th class="p-4 text-left">Merk</th>
                <th class="p-4 text-left">Plat Nomor</th>
                <th class="p-4 text-left">Tahun</th>
                <th class="p-4 text-left">Harga</th>
                <th class="p-4 text-left">Status</th>
                <th class="p-4 text-center">Aksi</th>

            </tr>

        </thead>

        <tbody class="divide-y divide-zinc-800">

            @forelse($kendaraans as $kendaraan)

            <tr class="hover:bg-zinc-800 transition">

                <td class="p-4 text-zinc-300">
                    {{ $loop->iteration }}
                </td>

                <td class="p-4 font-semibold text-white">
                    {{ $kendaraan->nama }}
                </td>

                <td class="p-4 text-zinc-300">
                    {{ $kendaraan->merk }}
                </td>

                <td class="p-4 text-zinc-300">
                    {{ $kendaraan->plat_nomor }}
                </td>

                <td class="p-4 text-zinc-300">
                    {{ $kendaraan->tahun }}
                </td>

                <td class="p-4 text-amber-400 font-semibold">
                    Rp {{ number_format($kendaraan->harga_sewa,0,',','.') }}
                </td>

                <td class="p-4">

                    @if($kendaraan->status=='tersedia')

                        <span class="px-3 py-1 rounded-full bg-green-500/20 text-green-400 text-sm">
                            Tersedia
                        </span>

                    @else

                        <span class="px-3 py-1 rounded-full bg-red-500/20 text-red-400 text-sm">
                            Disewa
                        </span>

                    @endif

                </td>

                <td class="p-4 text-center">

                    <a href="{{ route('admin.kendaraan.edit',$kendaraan->id) }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg">
                        Edit
                    </a>

                    <form action="{{ route('admin.kendaraan.destroy',$kendaraan->id) }}"
                          method="POST"
                          class="inline">

                        @csrf
                        @method('DELETE')

                        <button
                            onclick="return confirm('Yakin ingin menghapus?')"
                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg">

                            Hapus

                        </button>

                    </form>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="8" class="text-center py-12 text-zinc-500">

                    Belum ada data kendaraan

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>

</div>

@endsection